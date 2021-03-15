<?php

class ControllerDevDev extends Controller{

    public function index(){
        set_time_limit(30000);
        $this->document->setTitle('Полигон для тестов');
        $yaOauthToken='AgAAAAAGDt2cAATuwbezA_KH8kCwjBVcpLgBBZ0';
        $yaCloudFolderId='b1gib1joflubkol1863u';

        $yaIAMToken = $this->getYandexIAMToken4oauthToken($yaOauthToken);
        if(!is_string($yaIAMToken)){
            $content = $this->getPreContent4mixedData('Не удалось получить токен:',$yaIAMToken);
            $this->document->setContent('<div class="container">' . $content . '</div>');
            return new Action('common/html');
        }
        $objects = $this->getFiles4folder(DIR_STORAGE.'lang/en/');
        foreach($objects as $name => $object){
            if(is_file($name)) {
                $_ = array();
                require($name);
                $enTexts = array();
                $keyTexts = array();
                foreach ($_ as $key => $text){
                    $keyTexts[] = $key;
                    $enTexts[] = $text;
                }
                $ruTexts = $this->getTranslate($yaIAMToken,$yaCloudFolderId,$enTexts);
                $ruFileName = str_replace('\\en\\','\\ru\\',$name);

                $dirname = dirname($ruFileName);
                if (!is_dir($dirname)) mkdir($dirname, 0755, true);

                $ruFile = fopen($ruFileName,'w');
                fwrite($ruFile,'<?php'.PHP_EOL);
                foreach ($ruTexts as $key => $text){
                    fwrite($ruFile,'$_[\''.$keyTexts[$key].'\'] = \''.$text.'\';'.PHP_EOL);
                }
                fclose($ruFile);
            }
        }

        //$content = $this->getPreContent4mixedData('Ответ на Ваш запрос:',$files);
        $this->document->setContent('<div class="container">'.'Всё прошло успешно'.'</div>');
        return new Action('common/html');
    }

    private function getFiles4folder($path){
        $path = realpath($path);
        return new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path), RecursiveIteratorIterator::SELF_FIRST);
    }

    private function getPreContent4mixedData($msg='',$data=array()){
        $out = '<span>'.$msg.'</span><br />';
        $out .= '<pre style="border:1px solid rgba(0,0,0,0.5)">'.$this->rtf->print_rtf($data,true).'</pre><br />';
        return $out;
    }

    private function curl_init_and_exec($options = array()){
        $curl = curl_init();
        curl_setopt_array($curl, $options);
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    private function getYandexIAMToken4oauthToken($token=''){
        $responseYandexToken = $this->curl_init_and_exec(array(
            CURLOPT_URL => 'https://iam.api.cloud.yandex.net/iam/v1/tokens',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
            CURLOPT_POSTFIELDS => json_encode(array(
                'yandexPassportOauthToken'=>$token
            ))
        ));
        $responseYandexToken = json_decode($responseYandexToken);
        ($out = $responseYandexToken->iamToken) or ($out = $responseYandexToken);
        return $out;
    }

    private function getTranslate($iamToken='',$folder_id='',$texts=array()){
        $responseYandexTranslate = $this->curl_init_and_exec(array(
            CURLOPT_URL => 'https://translate.api.cloud.yandex.net/translate/v2/translate',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Bearer '.$iamToken
            ),
            CURLOPT_POSTFIELDS => json_encode(array(
                'folder_id'=>$folder_id,
                'texts'=>$texts,
                'targetLanguageCode'=>'ru'
            ))
        ));
        $responseYandexTranslate = json_decode($responseYandexTranslate);
        $texts = array();
        foreach ($responseYandexTranslate->translations as $translation){
            $texts[] = $translation->text;
        }
        return $texts;
    }
}