<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project as Project ;
use SSH;
use DB;

class ProjectController extends Controller
{
  //
  function insert(Request $request){

    $projecttype = $request['projecttype'];
    $projkey = "sit:kmutt:".str_random(6);

    if($projecttype == "repo"){
      $projrepo = $request['projectrepo'];
      $obj = new Project();
      $obj->projectname = $request['projectname'];
      $obj->projectrepo = $projrepo ;
      $obj->projectkey = $projkey;
      $obj->organization = $request['organization'];
      $obj->token = $request['token'];
      $obj->version = 1 ;
      $obj->encode = "UTF-8";
      $obj->save();

      SSH::into('sitsonar')->run(array(
        "ansible-playbook import.yml -e 'projkey=$projkey' -e 'gitrepo=$projrepo'",
      ));

      return redirect('/')->with('status',$projkey);

    }else if($projecttype == "upload"){

      $file = $request['projectrepo'];
      $original_name = $file->getClientOriginalName();
      $local_path = '../resources/tmpupload/'.$original_name;
      $remote_dir =  "/root/".$projkey ;
      $remote_path = $remote_dir."/".$original_name;

      $obj = new Project();
      $obj->projectname = $request['projectname'];
      $obj->projectrepo = $remote_path ;
      $obj->projectkey = $projkey;
      $obj->organization = $request['organization'];
      $obj->token = $request['token'];
      $obj->version = 1 ;
      $obj->encode = "UTF-8";
      $obj->save();

      $file->move('../resources/tmpupload', $original_name);

      SSH::into('sitsonar')->run(array(
        "mkdir $remote_dir",
      ));

      SSH::into('sitsonar')->put($local_path, $remote_path);

      SSH::into('sitsonar')->run(array(
        "unrar x  $remote_path $remote_dir",
      ));

      if(strpos($original_name, '.zip') !== false){
        // return "file extensions .zip";

        SSH::into('sitsonar')->run(array(
          "unzip $remote_path -d $remote_dir",
        ), function($line){
          return $line;
        });

      }else if(strpos($original_name, '.rar') !== false){
        // return "file extensions .rar";
        SSH::into('sitsonar')->run(array(
          "unrar x -y $remote_path $remote_dir",
        ));
      }

      return redirect('/')->with('status',$projkey);
    }




  }

  function select(Request $request){

    $obj = Project::where('projectkey', $request->key)->first();
    if($obj != null){
      return view('findproject')->with('project',$obj);
    }else{
      return redirect('/')->with('status',"keynotexist");
    }
  }

  function scan(Request $request){

    $obj = Project::where('projectkey', $request->projectkey)->first();
    $projectname = $obj->projectname ;
    $projectrepo = $obj->projectrepo ;
    $projectkey = $obj->projectkey ;
    $organization = $obj->organization ;
    $token = $obj->token ;
    $version = $obj->version ;
    $encode = $obj->encode ;

    $GLOBALS['status'] = 0 ;


    // ansible-playbook sonarsit.yml -e 'orgkey=sitsonar' -e 'projkey=sit:kmutt:1111111' -e 'projname=eieiei1234' -e 'projversion=1.0' -e 'token=37f221338f46121129ed11c315297d5b90fe18ca' -e 'gitrepo=https://github.com/FamHongtra/admintool.git'

    SSH::into('sitsonar')->run(array(
      // "ansible-playbook sonarsit.yml -e 'orgkey=$organization' -e 'projkey=$projectkey' -e 'projname=$projectname' -e 'projversion=$version' -e 'token=$token'",
      "sonar-scanner -Dsonar.host.url=https://sonarqube.com -Dsonar.organization=$organization -Dsonar.projectKey=$projectkey -Dsonar.projectName="."'".$projectname."'"." -Dsonar.projectVersion=$version -Dsonar.sources=$projectkey -Dsonar.sourceEncoding=$encode -Dsonar.login=$token"
    ),function($line){
      if (strpos($line, 'EXECUTION SUCCESS') !== false) {
        $GLOBALS['status'] = 1 ;
      }
    });

    if($GLOBALS['status']!=0){
      DB::table('projects')
      ->where('projectkey', $projectkey)
      ->increment('version');
      return redirect('/')->with('status',"success");
    }else{
      return redirect('/')->with('status',"failed");
    }

  }

  function update(Request $request){


  }



}
