<?php

namespace app\models\bitrix\app;

use App\HTTP\HTTP;
use Yii;
use yii\base\Model;

class Client extends Model
{
    public $access_token;
    public $refresh_token;
    public $client_endpoint;
    public $http;
    public $client_id;
    public $client_secret;

    private static $config_path = '/contractor/config/config.php';

    public function __construct($params = [])
    {
        static::$config_path = Yii::getAlias("@modules") . static::getConfigPath();
        $appsConfig = static::getConfig();

        $params = collect($params)->mapWithKeys(function ($item, $key){
            return [mb_strtolower($key) => $item];
        });

        $this->http = new HTTP();
        $this->http->throttle = 2;
        $this->http->useCookies = false;

        if($params->has("auth_id"))
        {
            $this->access_token = $params["auth_id"] ?? $appsConfig["Доступы"]["access_token"];
            $this->refresh_token = $params["refresh_id"] ?? $appsConfig["Доступы"]["refresh_token"];
        }
        else
        {
            $this->access_token = $params["access_token"] ?? $appsConfig["Доступы"]["access_token"];
            $this->refresh_token = $params["refresh_token"] ?? $appsConfig["Доступы"]["refresh_token"];
        }

        $this->client_id = $appsConfig["Доступы"]["client_id"];
        $this->client_secret = $appsConfig["Доступы"]["client_secret"];
        $this->client_endpoint = Yii::$app->params["bitrix"]["rest_url"];

        parent::__construct();
    }

    private static function getConfig()
    {
        return require static::$config_path;
    }

    public function request($method, $params = [])
    {
        $url = "{$this->client_endpoint}/{$method}.json";
        $params["auth"] = $this->access_token;

        $response = $this->http->request($url, "POST", $params);

        if(isset($response["error"]) && $response["error"] == "expired_token")
        {
            $this->refreshToken();
            $response = $this->request($method, $params);
        }

        return $response;
    }

    public function refreshToken():void
    {
        $params = [
            "grant_type" => "refresh_token",
            "client_id" => $this->client_id,
            "client_secret" => $this->client_secret,
            "refresh_token" => $this->refresh_token,
        ];

        $response = $this->http->request("https://oauth.bitrix.info/oauth/token/", "POST", $params);

        $this->access_token = $response['access_token'];
        $this->refresh_token = $response['refresh_token'];

        $this->updateConfig();
    }

    public function updateConfig()
    {
        $appsConfig = static::getConfig();

        if(!empty($appsConfig))
        {
            foreach ($appsConfig["Доступы"] as $key => &$value)
            {
                if($this->canGetProperty($key))
                {
                    $appsConfig["Доступы"][$key] = $this->$key;
                }
            }

            $appsConfig = var_export($appsConfig, true);

            file_put_contents(Yii::getAlias("@modules") . static::getConfigPath(), "<?php\n return {$appsConfig};\n");
        }
    }
	
	public function buildCommand($method, $params = [])
    {
        $command = "{$method}";

        if(!empty($params))
        {
            $command .= "?" . http_build_query($params);
        }

        return $command;
    }

    public function batchRequest($commands, $halt = true)
    {
        $url = "{$this->client_endpoint}/batch";

        $response = $this->http->request($url, "POST", ["cmd" => $commands, "halt" => $halt, 'auth' => $this->access_token]);


        if(isset($response["error"]) && $response["error"] == "expired_token")
        {
            $this->refreshToken();

            $response = $this->batchRequest($commands, $halt);
        }

        return $response;
    }
}