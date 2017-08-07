<?php
  header('Content-Type: text/html; charset=UTF-8');
  require_once 'soapSettings.php';
  $option=array(
    'trace'=>1,
    'soap_version'=> SOAP_1_1,
    'encoding'=>'UTF-8'
  );

  /**
   * Authentication class
   */
  class Authetication
  {
      public function Authetication($key, $user)
      {
          $this->accessKey = $key;
          $this->userName = $user;
      }
  }
  /**
   * Create auth object
   */
  $auth = new Authetication($ACCESSKEY, $USERNAME);

  /**
   * Create SoapClient
   */
  $client = new SoapClient('https://webservice.myschenker.fi/TESTewebsecure2_0/WebService2_0.svc?wsdl', $option);
  try {
      /**
       * Get Collection Points
       */
      $res = $client->getCollectionPointsByPostalCode(array('auth'=>$auth, 'postalCode'=>'00420'));
      $cp = $res->getCollectionPointsByPostalCodeResult->CollectionPoint;

      if (count($cp)==0) {
          echo "Not Connection point not found";
      } elseif (count($cp)==1) {
          echo $cp->Address1;
      } else {
          foreach ($cp as $p) {
              echo $p->Address1."<br>\n";
          }
      }
  } catch (Exception $e) {
      echo "Requests\n";
      var_dump($client->__getLastRequestHeaders());
      var_dump($client->__getLastRequest());

      echo "Responses\n";
      var_dump($client->__getLastRequestHeaders());
      var_dump($client->__getLastResponse());

      echo "<p>Error: ".$e->getMessage()."</p>\n";
  }
