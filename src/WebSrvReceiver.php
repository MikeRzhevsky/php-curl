<?php
/*Mikhail Rzhevsky
*/


class WebSrvReceiver
{
    protected $log_file = '/var/log/WebSrv.log';//path to log file, check access
    protected $data_file= '/home/mike/Documents/WebSrvData.csv';//path to data file from web service, check access

    public function __construct()
    {
        $this->run();
    }
    public function getSource()
    {

        //что такое curl https://ru.wikipedia.org/wiki/CURL
        // установка URL и других необходимых параметров
        // создание нового cURL ресурса
        if ($curl = curl_init()) {
            //читаем заголовки
            /*$url = "https://myblaze.ru";
            curl_setopt($curl, CURLOPT_URL,$url);
            curl_setopt($curl, CURLOPT_HEADER, 1); // читать заголовок
            curl_setopt($curl, CURLOPT_NOBODY, 1); // читать только заголовок без тела
            $result = curl_exec($curl);
            curl_close($curl); // завершение сеанса и освобождение ресурсов
            echo $result;*/

            //читаем тело сайта
            /*$url = "http://www.google.com/search?q=curl";
            curl_setopt($curl,CURLOPT_URL,$url);
            curl_setopt($curl,CURLOPT_HEADER, false);// не читать заголовок, читаем тело
            $result=curl_exec($curl);
            curl_close($curl);
            echo $result;*/

            //производим вычисления на удаленном хосте
            /*$url = "http://localhost/tutorial_curl/receiver.php?a=5&b=10"
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
            $out = curl_exec($curl);
            curl_close($curl);
            echo $out;*/

            //получаем данные с хоста
            $url = "http://localhost/tutorial_curl/source.php";
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, 'method=get');
            $out = curl_exec($curl);
            curl_close($curl);
            $out = json_decode($out, true);
            $out[response] = 'Success';
        }  else {
            $out = array(
                'response' => 'Error',
                'ErrorMessage' => 'Fail curl_init');
        }

        return $out;
    }
    public function run()
    {
        $out = $this->getSource();
        if ($out['response'] != 'Success') {
            $this->writeMsg($out,true);
        }
        else{
            $this->writeMsg($out);
        }
    }
    public function writeMsg($out,$iserror=false)
    {
        if ($iserror) {
            file_put_contents($this->log_file, $out['ErrorMessage'], FILE_APPEND);
            echo 'error';
        }else{
            $fp = fopen($this->data_file, 'w');
            foreach ($out as $key =>$value) {
                fputcsv($fp, $value);
            }
            fclose($fp);
            echo 'success';
        }

    }
}
