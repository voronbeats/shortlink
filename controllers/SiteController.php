<?php

namespace app\controllers;

use Yii;
use Endroid\QrCode\Builder\Builder;
use yii\web\Controller;
use yii\web\Response;
use app\models\Links;
use app\models\Logs;
use yii\web\NotFoundHttpException;

class SiteController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionCreate()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $url = Yii::$app->request->post('url');

        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            return ['error' => 'Некорректный URL'];
        }

        $headers = @get_headers($url);
        if (!$headers || strpos($headers[0], '200') === false) {
            return ['error' => 'Данный URL не доступен'];
        }

        $shortCode = substr(md5($url . time()), 0, 6);

        $link = new Links();
        $link->original_url = $url;
        $link->short_code = $shortCode;
        $link->created_at = date('Y-m-d H:i:s');
        $link->save();

        $shortUrl = Yii::$app->request->hostInfo . '/' . $shortCode;
        
        $result = Builder::create()->data($shortUrl)->build();

        $path = Yii::getAlias('@webroot/qr/') . $shortCode . '.png';
        $result->saveToFile($path);

        return [
            'short' => $shortUrl,
            'qr' => '/qr/' . $shortCode . '.png'
        ];
    }

    public function actionRedirect($code)
    {
        $link = Links::findOne(['short_code' => $code]);

        if (!$link) {
            throw new NotFoundHttpException();
        }

        $link->clicks += 1;
        $link->save();

        $log = new Logs();
        $log->link_id = $link->id;
        $log->ip = Yii::$app->request->userIP;
        $log->created_at = date('Y-m-d H:i:s');
        $log->save();

        return $this->redirect($link->original_url);
    }
}
