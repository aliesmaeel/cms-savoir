<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

trait SendEmailT
{
   public function sendEmail($receivers, $type)
   {
      $api_key = config('services.sendgrid.sendgrid_api_key');
      $url = config('services.sendgrid.sendgrid_url');
      $headers = array(
         'Authorization:' . $api_key,
         'accept: application/json',
         'Content-Type: application/json'
      );

      ///// types are:
      //// Body if select body
      //// Template if select template id

      if ($type == "Body") {

         $body = str_replace("\"", "'", $receivers["body"]);
         $payload = '{
            "personalizations": [{
               "to": ' . json_encode($receivers['to']) . '
            }],
            "from": {"email": "' . config('services.sendgrid.sendgrid_from_email') . '"}, 
            "subject": "This is my default subject line", 
            "content": [{"type": "text/html", "value": "' . $body . '"}]
         }';

         $payload = str_replace("\r", "", $payload);
         $payload = str_replace("\n", "", $payload);
      } else if ($type == "Templet") {
         $template_id = $receivers['template_id'];
         if ($template_id == null) {
            return response()->json(['status' => false, 'errors' => 'You should select template id']);
         }

         ////////////////////////////
         $payload = '{
            "personalizations": [{
               "to": ' . json_encode($receivers['to']) . '
            }],
                "template_id":' . $template_id . '
             }';
      }

      // Open connection
      $ch = curl_init();

      // Set the url, number of POST vars, POST data
      curl_setopt($ch, CURLOPT_URL, $url);

      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

      // Execute post
      $result = curl_exec($ch);
      $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
      if ($httpcode != 200 || $httpcode != 201) {
         Log::log("alert", "Send Email Result", ['result' =>  $result, 'message' => json_encode($receivers['to'])]);
      }
      return response()->json(['status' => true, 'message' => 'Emails has been sent successfully']);
   }

   public function sendEmailEventRequest($receivers, $params)
   {
      $api_key = config('services.sendgrid.sendgrid_api_key');
      $url = config('services.sendgrid.sendgrid_url');
      $headers = array(
         'Authorization:' . $api_key,
         'accept: application/json',
         'Content-Type: application/json'
      );

      ////////////////////////////
      ///////////
      // template name: Event Request

      $params['event_image'] =  str_replace("\\", "/", $params['event_image']);
      $params['event_image'] =  url('/') . '/' . $params['event_image'];
      $payload = '{
             "from":{
                "email":"' . config('services.sendgrid.sendgrid_from_email') . '"
             },
             "personalizations":[
                {
                  "to":' . json_encode($receivers) . ',
                  "dynamic_template_data":{
                     "requested_from":"' . $params['requested_from'] . '",
                     "event_name":"' . $params['name'] . '",
                     "event_date":"' . $params['date_format'] . '",
                     "event_address":"' . $params['address'] . '",
                     "event_image":"' . $params['event_image'] . '",
                     "event_type":"' . $params['event_type'] . '",
                     "event_description":"' . $params['description'] . '",
                     "approve_link":"' . url('/') . '/aproved/' . $params['id'] . '",
                     "reject_link":"' . url('/') . '/reject/' . $params['id'] . '"
                  }
                }
            ],
            "template_id":"d-c536c944ff62449ba6fb9413bedb5d01"
          }';

      $payload = str_replace("\r", "", $payload);
      $payload = str_replace("\n", "", $payload);

      // Open connection
      $ch = curl_init();

      // Set the url, number of POST vars, POST data
      curl_setopt($ch, CURLOPT_URL, $url);

      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

      // Execute post
      $result = curl_exec($ch);

      $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
      if ($httpcode != 200 || $httpcode != 201) {
         Log::log("alert", "Send Email Result", ['result' =>  $result, 'message' => json_encode($receivers)]);
      }
      return response()->json(['status' => true, 'message' => 'Emails has been sent successfully']);
   }

   public function sendEmailEventRejection($receivers, $params)
   {
      $api_key = config('services.sendgrid.sendgrid_api_key');
      $url = config('services.sendgrid.sendgrid_url');
      $headers = array(
         'Authorization:' . $api_key,
         'accept: application/json',
         'Content-Type: application/json'
      );

      ////////////////////////////
      ///////////
      // template name: New Event Rejected

      $params['event_image'] =  str_replace("\\", "/", $params['event_image']);
      $params['event_image'] =  url('/') . '/' . $params['event_image'];
      $payload = '{
         "from":{
            "email":"' . config('services.sendgrid.sendgrid_from_email') . '"
         },
         "personalizations":
         [
            {
               "to":' . json_encode($receivers) . ',
               "dynamic_template_data":
                  {
                     "event_name":"' . $params['name'] . '",
                     "event_date":"' . $params['date'] . '",
                     "event_address":"' . $params['address'] . '",
                     "event_description":"' . $params['description'] . '",
                     "event_image":"' . $params['event_image'] . '",
                     "event_type":"' . $params['event_type'] . '"
                  }
            }
         ],
         "template_id":"d-41705d474183489686937377f0f30e54"
         }';

      $payload = str_replace("\r", "", $payload);
      $payload = str_replace("\n", "", $payload);

      // Open connection
      $ch = curl_init();

      // Set the url, number of POST vars, POST data
      curl_setopt($ch, CURLOPT_URL, $url);

      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

      // Execute post
      $result = curl_exec($ch);
      dd($result);

      $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
      if ($httpcode != 200 || $httpcode != 201) {
         Log::log("alert", "Send Email Result", ['result' =>  $result, 'message' => json_encode($receivers)]);
      }
      return response()->json(['status' => true, 'message' => 'Emails has been sent successfully']);
   }

   public function sendEmailEventApproved($receivers, $params)
   {
      $api_key = config('services.sendgrid.sendgrid_api_key');
      $url = config('services.sendgrid.sendgrid_url');
      $headers = array(
         'Authorization:' . $api_key,
         'accept: application/json',
         'Content-Type: application/json'
      );

      ////////////////////////////
      ///////////
      // template name: New Event Approved

      $params['event_image'] =  str_replace("\\", "/", $params['event_image']);
      $params['event_image'] =  url('/') . '/' . $params['event_image'];
      $payload = '{
         "from":{
            "email":"' . config('services.sendgrid.sendgrid_from_email') . '"
         },
         "personalizations":
         [
            {
               "to":' . json_encode($receivers) . ',
               "dynamic_template_data":
                  {
                     "event_name":"' . $params['name'] . '",
                     "event_date":"' . $params['date'] . '",
                     "event_address":"' . $params['address'] . '",
                     "event_description":"' . $params['description'] . '",
                     "event_image":"' . $params['event_image'] . '",
                     "event_type":"' . $params['event_type'] . '",
                     "calendar_link":"' . url('/') . '/add_event_to_calendar/' . $params['id'] . '/1"
                  }
            }
         ],
         "template_id":"d-047e7f38e42c4593b91fea2858041cad"
         }';

      $payload = str_replace("\r", "", $payload);
      $payload = str_replace("\n", "", $payload);

      // Open connection
      $ch = curl_init();

      // Set the url, number of POST vars, POST data
      curl_setopt($ch, CURLOPT_URL, $url);

      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

      // Execute post
      $result = curl_exec($ch);

      $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
      if ($httpcode != 200 || $httpcode != 201) {
         Log::log("alert", "Send Email Result", ['result' =>  $result, 'message' => json_encode($receivers)]);
      }
      return response()->json(['status' => true, 'message' => 'Emails has been sent successfully']);
   }

   public function sendEmailMeetingCreated($receivers, $params)
   {
      $api_key = config('services.sendgrid.sendgrid_api_key');
      $url = config('services.sendgrid.sendgrid_url');
      $headers = array(
         'Authorization:' . $api_key,
         'accept: application/json',
         'Content-Type: application/json'
      );

      ////////////////////////////
      ///////////
      // template name: New Meeting Created

      $payload = '{
         "from":{
            "email":"' . config('services.sendgrid.sendgrid_from_email') . '"
         },
         "personalizations":
         [
            {
               "to":' . json_encode($receivers) . ',
               "dynamic_template_data":
                  {
                     "title":"' . $params['title'] . '",
                     "description":"' . $params['description'] . '",
                     "datetime":"' . $params['datetime'] . '",
                     "calendar_link":"' . url('/') . '/add_meeting_to_calendar/' . $params['id'] . '"
                  }
            }
         ],
         "template_id":"d-7b8b6c75877249ecb4fc356af81d314e"
         }';

      $payload = str_replace("\r", "", $payload);
      $payload = str_replace("\n", "", $payload);

      // Open connection
      $ch = curl_init();

      // Set the url, number of POST vars, POST data
      curl_setopt($ch, CURLOPT_URL, $url);

      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

      // Execute post
      $result = curl_exec($ch);

      $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
      if ($httpcode != 200 || $httpcode != 201) {
         Log::log("alert", "Send Email Result", ['result' =>  $result, 'message' => json_encode($receivers)]);
      }
      return response()->json(['status' => true, 'message' => 'Emails has been sent successfully']);
   }

   public function sendEmailEventCreated($receivers, $params)
   {
      $api_key = config('services.sendgrid.sendgrid_api_key');
      $url = config('services.sendgrid.sendgrid_url');
      $headers = array(
         'Authorization:' . $api_key,
         'accept: application/json',
         'Content-Type: application/json'
      );

      ////////////////////////////
      ///////////
      // template name: New Event Created

      $params['event_image'] =  str_replace("\\", "/", $params['event_image']);
      $params['event_image'] =  url('/') . '/' . $params['event_image'];
      $payload = '{
         "from":{
            "email":"' . config('services.sendgrid.sendgrid_from_email') . '"
         },
         "personalizations":
         [
            {
               "to":' . json_encode($receivers) . ',
               "dynamic_template_data":
                  {
                     "event_name":"' . $params['name'] . '",
                     "event_date":"' . $params['date'] . '",
                     "event_address":"' . $params['address'] . '",
                     "event_description":"' . $params['description'] . '",
                     "event_image":"' . $params['event_image'] . '",
                     "event_type":"' . $params['event_type'] . '",
                     "calendar_link":"' . url('/') . '/add_event_to_calendar/' . $params['id'] . '/1",
                     "attend_link":"' . $params['attend_link'] . '"
                  }
            }
         ],
         "template_id":"d-fc43d3e7024041869224261c432afb3a"
         }';

      $payload = str_replace("\r", "", $payload);
      $payload = str_replace("\n", "", $payload);

      // Open connection
      $ch = curl_init();

      // Set the url, number of POST vars, POST data
      curl_setopt($ch, CURLOPT_URL, $url);

      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

      // Execute post
      $result = curl_exec($ch);

      $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
      if ($httpcode != 200 || $httpcode != 201) {
         Log::log("alert", "Send Email Result", ['result' =>  $result, 'message' => json_encode($receivers)]);
      }
      return response()->json(['status' => true, 'message' => 'Emails has been sent successfully']);
   }

   public function sendEmailAppointmentRequest($receivers, $params)
   {
      $api_key = config('services.sendgrid.sendgrid_api_key');
      $url = config('services.sendgrid.sendgrid_url');
      $headers = array(
         'Authorization:' . $api_key,
         'accept: application/json',
         'Content-Type: application/json'
      );


      ////////////////////////////
      ///////////
      // template name: Appointment Request

      $payload = '{
             "from":{
                "email":"' . config('services.sendgrid.sendgrid_from_email') . '"
             },
             "personalizations":[
               {
                "to":' . json_encode($receivers) . ',
                "dynamic_template_data":
                {
                  "photographer_name":"' . $params['photographer_name'] . '",
                  "title":"' . $params['title'] . '",
                  "date":"' . $params['date'] . '",
                  "time":"' . $params['time'] . '",
                  "building_name":"' . $params['building_name'] . '",
                  "apartment_number":"' . $params['apartment_number'] . '",
                  "comment":"' . $params['comment'] . '",
                  "photoshoot_type":"' . $params['photoshoot'] . '",
                  "confirm_link":"' . url('/') . '/confirmappointment/' . $params['appointment_id'] . '/' . $params['agent_id'] . '",
                  "reject_link":"' . url('/') . '/rejectappointment/' . $params['appointment_id'] . '/' . $params['agent_id'] . '"
                }
             }],
            "template_id":"d-4413b624155848a3ac105258c04558f1"
          }';

      $payload = str_replace("\r", "", $payload);
      $payload = str_replace("\n", "", $payload);

      // Open connection
      $ch = curl_init();

      // Set the url, number of POST vars, POST data
      curl_setopt($ch, CURLOPT_URL, $url);

      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

      // Execute post
      $result = curl_exec($ch);

      $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
      if ($httpcode != 200 || $httpcode != 201) {
         Log::log("alert", "Send Email Result", ['result' =>  $result, 'message' => json_encode($receivers)]);
      }
      return response()->json(['status' => true, 'message' => 'Emails has been sent successfully']);
   }

   public function sendEmailAppointmentApproved($receivers, $params, $type)
   {
      $api_key = config('services.sendgrid.sendgrid_api_key');
      $url = config('services.sendgrid.sendgrid_url');
      $headers = array(
         'Authorization:' . $api_key,
         'accept: application/json',
         'Content-Type: application/json'
      );


      ////////////////////////////
      ///////////
      // template name: Appointment Approved

      $payload = '{
             "from":{
                "email":"' . config('services.sendgrid.sendgrid_from_email') . '"
             },
             "personalizations":[{
                "to":' . json_encode($receivers) . ',
                "dynamic_template_data":{
                  "agent_name":"' . $params['name'] . '",
                  "date":"' . $params['date'] . '",
                  "time":"' . $params['time'] . '",
                  "photographer_name":"' . $params['photographer_name'] . '",
                  "photoshoot_type":"' . $params['photoshoot'] . '",
                  "location":"' . $params['location'] . '",
                  "calendar_link":"' . url('/') . '/add_event_to_calendar/' . $params['id'] . '/2"
                }
             }],
             "template_id":"d-5a976d06c743403a9194ef69d239061e"
            }
          }';

      $payload = str_replace("\r", "", $payload);
      $payload = str_replace("\n", "", $payload);

      // Open connection
      $ch = curl_init();

      // Set the url, number of POST vars, POST data
      curl_setopt($ch, CURLOPT_URL, $url);

      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

      // Execute post
      $result = curl_exec($ch);

      $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
      if ($httpcode != 200 || $httpcode != 201) {
         Log::log("alert", "Send Email Result", ['result' =>  $result, 'message' => json_encode($receivers)]);
      }
      return response()->json(['status' => true, 'message' => 'Emails has been sent successfully']);
   }

   public function sendEmailAppointmentRejected($receivers, $params, $type)
   {
      $api_key = config('services.sendgrid.sendgrid_api_key');
      $url = config('services.sendgrid.sendgrid_url');
      $headers = array(
         'Authorization:' . $api_key,
         'accept: application/json',
         'Content-Type: application/json'
      );


      ////////////////////////////
      ///////////
      // template name: Appointment Rejected

      $payload = '{
         "from":{
            "email":"' . config('services.sendgrid.sendgrid_from_email') . '"
         },
         "personalizations":[
            {
               "to":' . json_encode($receivers) . ',
               "dynamic_template_data":{
                     "agent_name":"' . $params['name'] . '",
                     "date":"' . $params['date'] . '",
                     "time":"' . $params['time'] . '",
                     "photographer_name":"' . $params['photographer_name'] . '",
                     "photoshoot_type":"' . $params['photoshoot'] . '",
                     "location":"' . $params['location'] . '"
                  }
            }
         ],
            "template_id":"d-20509c25a1174398838547159c8e9194",
          }';

      $payload = str_replace("\r", "", $payload);
      $payload = str_replace("\n", "", $payload);

      // Open connection
      $ch = curl_init();

      // Set the url, number of POST vars, POST data
      curl_setopt($ch, CURLOPT_URL, $url);

      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

      // Execute post
      $result = curl_exec($ch);

      $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
      if ($httpcode != 200 || $httpcode != 201) {
         Log::log("alert", "Send Email Result", ['result' =>  $result, 'message' => json_encode($receivers)]);
      }
      return response()->json(['status' => true, 'message' => 'Emails has been sent successfully']);
   }

   public function sendEmailNewUser($receivers, $params)
   {
      $api_key = config('services.sendgrid.sendgrid_api_key');
      $url = config('services.sendgrid.sendgrid_url');
      $headers = array(
         'Authorization:' . $api_key,
         'accept: application/json',
         'Content-Type: application/json'
      );

      ////////////////////////////
      ///////////
      // template name: New User

      $payload = '{
         "from":{
            "email":"' . config('services.sendgrid.sendgrid_from_email') . '"
         },
         "personalizations":[{
            "to":' . json_encode($receivers) . ',
            "dynamic_template_data":{
              "admin_name":"' . $params['admin_name'] . '",
              "created_date":"' . $params['created_date'] . '",
              "role":"' . $params['role'] . '",
              "email":"' . $params['email'] . '",
              "password":"' . $params['password'] . '",
              "login_link":"' . $params['login_link'] . '"
           }
         }],
            "template_id": "d-6341f32805fc486c8be70a10f37405b9"
          }';

      $payload = str_replace("\r", "", $payload);
      $payload = str_replace("\n", "", $payload);

      // Open connection
      $ch = curl_init();

      // Set the url, number of POST vars, POST data
      curl_setopt($ch, CURLOPT_URL, $url);

      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

      // Execute post
      $result = curl_exec($ch);

      $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
      if ($httpcode != 200 || $httpcode != 201) {
         Log::log("alert", "Send Email Result", ['result' =>  $result, 'message' => json_encode($receivers)]);
      }
      return response()->json(['status' => true, 'message' => 'Emails has been sent successfully']);
   }

   public function sendEmailNewLead($receivers, $params)
   {
      $api_key = config('services.sendgrid.sendgrid_api_key');
      $url = config('services.sendgrid.sendgrid_url');
      $headers = array(
         'Authorization:' . $api_key,
         'accept: application/json',
         'Content-Type: application/json'
      );

      ////////////////////////////
      ///////////
      // template name: Leads Assignment

      $payload = '{
         "from":{
            "email":"' . config('services.sendgrid.sendgrid_from_email') . '"
         },
         "personalizations":[{
            "to":' . json_encode($receivers) . ',
            "dynamic_template_data":{
              "agent_name":"' . $params['agent_name'] . '",
              "data_source":"' . $params['data_source'] . '"
           }
         }],
            "template_id": "d-3b6769a796e6456db53d6a138932c304"
          }';

      $payload = str_replace("\r", "", $payload);
      $payload = str_replace("\n", "", $payload);

      // Open connection
      $ch = curl_init();

      // Set the url, number of POST vars, POST data
      curl_setopt($ch, CURLOPT_URL, $url);

      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

      // Execute post
      $result = curl_exec($ch);

      $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
      if ($httpcode != 200 || $httpcode != 201) {
         Log::log("alert", "Send Email Result", ['result' =>  $result, 'message' => json_encode($receivers)]);
      }
      return response()->json(['status' => true, 'message' => 'Emails has been sent successfully']);
   }

   public function sendEmailNewLeadAdmin($receivers, $params)
   {
      $api_key = config('services.sendgrid.sendgrid_api_key');
      $url = config('services.sendgrid.sendgrid_url');
      $headers = array(
         'Authorization:' . $api_key,
         'accept: application/json',
         'Content-Type: application/json'
      );

      ////////////////////////////
      ///////////
      // template name: New Lead

      $payload = '{
             "from":{
                "email":"' . config('services.sendgrid.sendgrid_from_email') . '"
             },
             "personalizations":[{
                "to":' . json_encode($receivers) . ',
                "dynamic_template_data":{
                  "admin_name":"' . $params['admin_name'] . '",
                  "data_source":"' . $params['data_source'] . '"
                }
             }],
             "template_id": "d-e9a0b58e55ce4c3faa7e6a4d9edb635c"
          }';

      $payload = str_replace("\r", "", $payload);
      $payload = str_replace("\n", "", $payload);

      // Open connection
      $ch = curl_init();

      // Set the url, number of POST vars, POST data
      curl_setopt($ch, CURLOPT_URL, $url);

      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

      // Execute post
      $result = curl_exec($ch);
      return response()->json(['status' => true, 'message' => 'Emails has been sent successfully']);
   }

   public function fileImportedCompleted($receivers, $params)
   {
      $api_key = config('services.sendgrid.sendgrid_api_key');
      $url = config('services.sendgrid.sendgrid_url');
      $headers = array(
         'Authorization:' . $api_key,
         'accept: application/json',
         'Content-Type: application/json'
      );

      ////////////////////////////
      ///////////
      // template name: New User

      $payload = '{
         "from":{
            "email":"' . config('services.sendgrid.sendgrid_from_email') . '"
         },
         "personalizations":[{
            "to":' . json_encode($receivers) . ',
            "dynamic_template_data":{
              "file_name":"' . $params['file_name'] . '"
           }
         }],
            "template_id": "d-8a97dba2e39b418784173da8b30e36ad"
          }';

      $payload = str_replace("\r", "", $payload);
      $payload = str_replace("\n", "", $payload);

      // Open connection
      $ch = curl_init();

      // Set the url, number of POST vars, POST data
      curl_setopt($ch, CURLOPT_URL, $url);

      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

      // Execute post
      $result = curl_exec($ch);

      $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
      if ($httpcode != 200 || $httpcode != 201) {
         Log::log("alert", "Send Email Result", ['result' =>  $result, 'message' => json_encode($receivers)]);
      }
      return response()->json(['status' => true, 'message' => 'Emails has been sent successfully']);
   }

   public function sendErrorEmail($receivers, $params)
   {
      $api_key = config('services.sendgrid.sendgrid_api_key');
      $url = config('services.sendgrid.sendgrid_url');
      $headers = array(
         'Authorization:' . $api_key,
         'accept: application/json',
         'Content-Type: application/json'
      );

      ////////////////////////////
      ///////////
      // template name: New User

      if (!$receivers) {
         $receivers = [['email' => 'cto@start-tech.ae']];
      }

      $payload = '{
         "from":{
            "email":"' . config('services.sendgrid.sendgrid_from_email') . '"
         },
         "personalizations":[{
            "to":' . json_encode($receivers) . ',
            "dynamic_template_data":{
              "source":"' . $params['source'] . '",
              "message":"' . $params['message'] . '"
           }
         }],
            "template_id": "d-338a623f024842ba9e03378f5753386a"
          }';

      $payload = str_replace("\r", "", $payload);
      $payload = str_replace("\n", "", $payload);

      // Open connection
      $ch = curl_init();

      // Set the url, number of POST vars, POST data
      curl_setopt($ch, CURLOPT_URL, $url);

      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

      // Execute post
      $result = curl_exec($ch);

      $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
      if ($httpcode != 200 || $httpcode != 201) {
         Log::log("alert", "Send Email Result", ['result' =>  $result, 'message' => json_encode($receivers)]);
      }
      return response()->json(['status' => true, 'message' => 'Emails has been sent successfully']);
   }
}
