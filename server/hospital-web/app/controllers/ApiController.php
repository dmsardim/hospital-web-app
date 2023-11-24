<?php

use Phalcon\Http\Response;
use Phalcon\Http\Request;

class ApiController extends \Phalcon\Mvc\Controller {
    

 // /api/getPatients
 public function getPatientsAction() {
  $this->view->disable();
  $response = new Response();
  $request = new Request();

  if ($request->isGet()) {
      $data = Patients::find();
      $response->setStatusCode(200, 'OK');
      $response->setJsonContent(["status" => [
          "code" => 200,
          "response" => "success",
          "message" => "Success get all data"
      ], "result" => $data]);
  } else {
      $response->setStatusCode(405, 'Method Not Allowed');
      $response->setJsonContent(["status" => false, "error" => "Method Not Allowed"]);
  }
  $response->send();
 }

//  /api/getPatient/{id}
 public function getPatientAction($id) {
     $this->view->disable();
     $response = new Response();
     $request = new Request();

     if ($request->isGet()) {
         $statusCode = 200;
         $messageRes = "Success get data by id";
         $resStatus = "success";
         // invoke static method
         $data = Patients::findFirst($id);

         if ($data === null) {
             $statusCode = 404;
             $messageRes = "Failed, data with id: " . $id . " not found";
             $resStatus = "failed";
         }
         $response->setStatusCode($statusCode);
         $response->setJsonContent(["status" => [
             "code" => $statusCode,
             "response" => $resStatus,
             "message" => $messageRes
         ], "result" => $data]);
     } else {
         $response->setStatusCode(405, 'Method Not Allowed');
         $response->setJsonContent(["status" => false, "error" => "Method Not Allowed"]);
     }

     $response->send();
 }

//  /api/addPatient
 public function addPatientAction() {
        $this->view->disable();
        $response = new Response();
        $request = new Request();

        $response->setHeader('Access-Control-Allow-Origin', '*');
        $response->setHeader('Access-Control-Allow-Methods', 'GET,POST,PUT,DELETE,OPTIONS');
        $response->setHeader('Access-Control-Allow-Headers', 'Origin, X-Requested-With, Content-Range, Content-Disposition, Content-Type');
        $response->setHeader("Access-Control-Allow-Credentials", true);

        if ($request->isPost()) {
            $statusCode = 200;
            $messageRes = "Successfully add patient";
            $resStatus = "success";

            $patient = new Patients();
            $patient->name = $request->getPost("name");
            $patient->sex = $request->getPost("sex");
            $patient->religion = $request->getPost("religion");
            $patient->nik = $request->getPost("nik");
            $patient->phone = $request->getPost("phone");
            $patient->address = $request->getPost("address");

            if ($patient->create() === false) {
                $statusCode = 400;
                $resStatus = "failed";
                $messageRes = "Failed add new patient";

                $patient = $patient->getMessages();
            }

            $response->setStatusCode($statusCode);

            $response->setJsonContent(["status" => [
                "code" => $statusCode,
                "response" => $resStatus,
                "message" => $messageRes
            ], "result" => $patient]);
        } else {
            $response->setStatusCode(405, 'Method Not Allowed');
            $response->setJsonContent(["status" => false, "error" => "Method Not Allowed"]);
        }
        $response->send();
    }

    //  /api/editPatient/{id}
    public function editPatientAction($id){
        $this->view->disable();
        $response = new Response();
        $request = new Request();

        if ($request->isPost()) {
            $statusCode = 200;
            $messageRes = "Successfully edit patient";
            $resStatus = "success";

            $patient = Patients::findFirst($id);
            if (!$patient) {
                $statusCode = 404;
                $messageRes = "Failed, data with id: " . $id . " not found";
                $resStatus = "failed";
            } else {
                $patient->name = $request->getPost("name");
                $patient->sex = $request->getPost("sex");
                $patient->religion = $request->getPost("religion");
                $patient->nik = $request->getPost("nik");
                $patient->phone = $request->getPost("phone");
                $patient->address = $request->getPost("address");
                if ($patient->save() === false) {
                    $statusCode = 400;
                    $resStatus = "failed";
                    $messageRes = "Failed edit patient";

                    $patient = $patient->getMessages();
                }
            }

            $response->setStatusCode($statusCode);

            $response->setJsonContent(["status" => [
                "code" => $statusCode,
                "response" => $resStatus,
                "message" => $messageRes
            ], "result" => $patient]);
        } else {
            $response->setStatusCode(405, 'Method Not Allowed');
            $response->setJsonContent(["status" => false, "error" => "Method Not Allowed"]);
        }

        $response->send();
    }

    //  /api/deletePatient/{id}
    public function deletePatientAction($id){
        $this->view->disable();
        $response = new Response();
        $request = new Request();


        if ($request->isGet()) {
            $statusCode = 200;
            $messageRes = "Successfully delete patient";
            $resStatus = "success";

            $patient = Patients::findFirst($id);

            if (!$patient) {
                $statusCode = 404;
                $messageRes = "Failed, data with id: " . $id . " not found";
                $resStatus = "failed";
            } else {
                if ($patient->delete() === false) {
                    $statusCode = 500;
                    $messageRes = "Failed delete patient";
                    $resStatus = "failed";
                }
            }

            $response->setJsonContent(["status" => [
                "code" => $statusCode,
                "response" => $resStatus,
                "message" => $messageRes
            ]]);
        } else {
            $response->setStatusCode(405, 'Method Not Allowed');
            $response->setJsonContent(["status" => false, "error" => "Method Not Allowed"]);
        }
        $response->send();
    }
}