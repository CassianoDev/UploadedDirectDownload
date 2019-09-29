<?php
/* UPLOADED CLASS DIRECT DOWNLOAD FOR FFMPEG PLAYLIST 24 HOURS CHANNELS*/

class uploaded {
  private $User;
  private $Pass;
  private $Link;
  private $Ch;
  private $linkFile;
  private $ChContents;
  private $ListFolder;
  private $Ip = IP_HOST;
  private $Port = IP_PORT;
  private $CookiePatch = COOKIE_PATCH;

  public function __construct($Link,$ListFolder = 0){
    if(UPLOADED_USER == "" || UPLOADED_PASS == "" || $Link == ""){
      echo "Error, missing user or pass or link";
      exit;
    }
    $this->User = UPLOADED_USER;
    $this->Pass = UPLOADED_PASS;
    $this->Link = $Link;
    $this->ListFolder = $ListFolder;
    if(file_exists($this->CookiePatch)){
      $this->Ch = curl_init();
      $this->Login();
      if($this->ChContents["error"]){
        echo $this->ChContents["msg"];
        exit;
      } else {
        $this->ExecuteLines();
      }
    } else {
      echo "'cookie.txt' not found, please execute: touch /usr/share/cookie.txt and chmod 777 /usr/share/cookie.txt";
      exit;
    }
  }

  private function Login(){
    $now = time(); //you should put this outside of the loop
    if($now - filemtime($this->CookiePatch) > 24 * 60 * 60 || file_get_contents($this->CookiePatch) == ""){
      curl_setopt($this->Ch, CURLOPT_URL, "http://uploaded.net/io/login");
      curl_setopt($this->Ch, CURLOPT_REFERER, "http://uploaded.net/me");
      curl_setopt($this->Ch, CURLOPT_USERAGENT, USER_AGENT);
      curl_setopt($this->Ch, CURLOPT_COOKIEFILE, $this->CookiePatch);
      curl_setopt($this->Ch, CURLOPT_COOKIEJAR, $this->CookiePatch);
      curl_setopt($this->Ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($this->Ch, CURLOPT_POST, 1);
      curl_setopt($this->Ch, CURLOPT_POSTFIELDS, "id=$this->User&pw=$this->Pass");
      $this->ChContents = $this->CheckLogin(curl_exec($this->Ch));
    } else {
      curl_setopt($this->Ch, CURLOPT_URL, "http://uploaded.net/me");
      curl_setopt($this->Ch, CURLOPT_REFERER, "http://uploaded.net");
      curl_setopt($this->Ch, CURLOPT_USERAGENT, USER_AGENT);
      curl_setopt($this->Ch, CURLOPT_COOKIEFILE, $this->CookiePatch);
      curl_setopt($this->Ch, CURLOPT_HEADER, true);    // we want headers
      curl_setopt($this->Ch, CURLOPT_NOBODY, true);    // we don't need body
      curl_setopt($this->Ch, CURLOPT_RETURNTRANSFER, 1);
      curl_exec($this->Ch);
      $httpcode = curl_getinfo($this->Ch, CURLINFO_HTTP_CODE);
      $this->ChContents = $this->CheckLogin($httpcode);
    }
  }

  private function CheckLogin($Content){
    if(!empty(json_decode($Content)->err) || $Content != "200"){
      return ["error" => true,"msg"=> "Login error!!!"];
    } else {
      return ["error" => false,"msg"=> "Login ok!!!"];
    }
  }

  private function TurnOffDirecDownload(){
    curl_setopt($this->Ch, CURLOPT_URL, "http://uploaded.net/io/me/ddl");
    curl_setopt($this->Ch, CURLOPT_REFERER, "http://uploaded.net/me");
    curl_setopt($this->Ch, CURLOPT_USERAGENT, USER_AGENT);
    curl_setopt($this->Ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($this->Ch, CURLOPT_POST, 1);
    curl_setopt($this->Ch, CURLOPT_POSTFIELDS, "ddl=false&_=");
    curl_exec($this->Ch);
  }

  private function GetDownload(){
    curl_setopt($this->Ch, CURLOPT_URL, $this->Link);
    curl_setopt($this->Ch, CURLOPT_REFERER, $this->Link);
    curl_setopt($this->Ch, CURLOPT_USERAGENT, USER_AGENT);
    curl_setopt($this->Ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($this->Ch, CURLOPT_POST, 1);
    $this->ChContents = curl_exec($this->Ch);
  }

  private function FilterLink($GetFilesOfFolders = 0){
    if(!$GetFilesOfFolders){
      $this->linkFile = trim(explode('"',explode("action=",$this->ChContents)[1])[1]);
    } else {
      preg_match_all('/<a[^>]+class="file"[^>]*>(.*)<\/a>/',$this->ChContents, $files);
      preg_match_all('/<a href="(.*?)"/s', implode("\n",$files[0]), $matches);
      foreach($matches[1] as $links){
        echo "http://$this->Ip:$this->Port/uploaded?url=http://uploaded.net/".$links."<br />";
      }
    }
  }

  private function TestLink(){
    if(READ_INTERNAL){
      if(!empty(readfile($this->linkFile))){
        //
      } else {
        return false;
      }
    } else {
      if(!empty(get_headers($this->linkFile))){
        return true;
      } else {
        return false;
      }
    }

  }

  private function ExecuteLines(){
    $this->TurnOffDirecDownload();
    $this->GetDownload();
    $this->FilterLink($this->ListFolder); //set 1 for get list of files folder
    if(!$this->ListFolder){
      if($this->TestLink()){
        if(!READ_INTERNAL){
          header("Location: $this->linkFile",301);
        }    
      } else {
        $this->ExecuteLines();
      }
    }
  }
}
