<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;
use App\User;
use App\Role;
use App\CopyEditing;
use App\Permission;
use App\Authorizable;
use App\Mail\AppMailler;
use Mail;
use File;
use App\LoginTeam;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use DB;
use Illuminate\Support\Facades\Crypt;


class LoginTeamController extends Controller
{
    public function dashBoard()
    {
    	$client = Client::getAllClientCount();
        $chapter = LoginTeam::getChapterCount();
        $book = Client::getAllBookCount();
        $journal = Client::getJournal();   
    	return view('loginteam.dashboard', compact('book', 'chapter', 'client'));
    }

    public function show()
    {
    	$clients = Client::getAllClient();
    	$result = LoginTeam::getChapter();
        $types = Client::getType();

        return view('loginteam.chapter', compact('result', 'clients', 'types'));
    }

    public function bookList() {
        $clients = Client::getAllClient();
        $result = LoginTeam::getBooks();
        $types = Client::getType();

        return view('loginteam.booklist', compact('result', 'clients', 'types'));    
    }

    public function getClientJournal(Request $request)
    {
    	$journal = Client::getJournalByClientId($request->get('id'));
    	return $journal;
    }

    public function createBook(Request $request) {
        $this->validate($request, ['type' => 'required|min:1', 'client' => 'required|min:1', 'journal' => 'required|min:1', 'book' => 'required|min:1']);
        $client = Client::getJournalById($request->get('journal'));
        $path = $client->file_path.'/'.$request->get('book');

        if(!File::exists($path)) {
            File::makeDirectory($path, $mode = 0777, true, true);
        }
        
        $createdBy = Auth::user()->id;
        $now = date("Y-m-d h:i:s");
        $bookArray = [
        'type' => $request->get('type'),
        'client_id' => $request->get('client'),
        'journal_id' => $request->get('journal'),
        'book_name' => $request->get('book'),
        'file_path' => $path,
        'created_by' => $createdBy,
        'created_at' => $now];
        LoginTeam::createBook($bookArray);
        flash('Book Added');

        return redirect()->back();
    }

    public function createChapter(Request $request)
    {
    	$this->validate($request, ['type' => 'required|min:1', 'name' => 'required|unique:roles', 'client' => 'required|min:1', 'journal' => 'required|min:1', 'book' => 'required|min:1']);
    	$client = LoginTeam::getBookById($request->get('book'));

        $chapterPath = $client->file_path.'/'.$request->get('name');

        if(!File::exists($chapterPath)) {
            File::makeDirectory($chapterPath, $mode = 0777, true, true);
        }
    	
        $createdBy = Auth::user()->id;
        $now = date("Y-m-d h:i:s");
        $chapterArray = [
        'type' => $request->get('type'),
        'client_id' => $request->get('client'),
        'journal_id' => $request->get('journal'),
        'chapter_name' => $request->get('name'),
        'book_id' => $request->get('book'),
        'file_path' => $chapterPath,
        'created_by' => $createdBy,
        'created_at' => $now];
    	LoginTeam::createChapter($chapterArray);
    	flash('Chapter Added');
        return redirect()->back();
    }

    public function upload() {
        $clients = Client::getClient();
        // $clients = Client::getAllClientCount();
        $stages = LoginTeam::getArticleStage();
        $types = Client::getType();

        return view('loginteam.upload', compact('clients', 'stages', 'types'));
    }

    public function getClientBook(Request $request) {
        $book = LoginTeam::getBookByClientId($request->get('type_id'), $request->get('client_id'), $request->get('journal_id'));
        return $book;
    }

    public function getClientChapter(Request $request) {
        $chapter = LoginTeam::getChapterByClientId($request->get('type_id'), $request->get('client_id'), $request->get('journal_id'), $request->get('book_id'));
        return $chapter;
    }

    public function getChapterStage(Request $request) {
        $stage = LoginTeam::getChapterSubStage($request->get('stage_id'));
        return $stage;    
    }

    public function chapterUpload(Request $request) {

        $this->validate($request, [
            'type' => 'required|min:1',
            'client' => 'required|min:1', 
            'journal' => 'required|min:1',
            'book' => 'required|min:1',
            'chapter' => 'required|min:1',
            'custrev' => 'required|min:1',
            'custacc' => 'required|min:1',
            'articlestage' => 'required|min:1',
            'articlesubstage' => 'required|min:1',
            'file' => 'required|min:1'
            ]);
        
        $typeid = $request->get('type');
        $clientid = $request->get('client');
        $journalid = $request->get('journal');
        $bookid = $request->get('book');
        $chapterid = $request->get('chapter');
        $custrev = $request->get('custrev');
        $custacc = $request->get('custacc');
        $msword = $request->get('msword');
        $noofta = $request->get('noofta');
        $nooffig = $request->get('nooffig');
        $doi = $request->get('doi');
        $query = $request->get('query');
        $articlestage = $request->get('articlestage');
        $articlesubstage = $request->get('articlesubstage');

        $subStage = LoginTeam::getSubStageById($request->get('articlesubstage'));
        $client = LoginTeam::getChapterById($request->get('chapter'));
        $stagePath = $client->file_path.'/'.$subStage->stage;
        $subStagePath = $stagePath.'/'.$subStage->sub_stage;
        $inputPath = $subStagePath.'/Input//';
        
        if(!File::exists($stagePath)) {
            File::makeDirectory($stagePath, $mode = 0777, true, true);
        }

        if(!File::exists($subStagePath)) {
            File::makeDirectory($subStagePath, $mode = 0777, true, true);
        }

        if(!File::exists($inputPath)) {
            File::makeDirectory($inputPath, $mode = 0777, true, true);
        }
            
        $file = $request->file('file');
        $filePath =$inputPath.'/'.$file->getClientOriginalName();
        
        if($file->move($inputPath,$file->getClientOriginalName())) {
            $now = date("Y-m-d h:i:s");
            $fileName = $file->getClientOriginalName();          
            $uploadArray = ['type' => $typeid, 'client_id' => $clientid, 'journal_id' => $journalid, 'book_id' => $bookid, 'chapter_id' => $chapterid, 'received_date' => $custrev, 'accepted_date' => $custacc, 'msword' => $msword, 'no_of_table' => $noofta, 'no_of_figure' => $nooffig, 'doi' => $doi, 'query' => $query, 'article_stage' => $articlestage, 'article_sub_stage' => $articlesubstage, 'stage_file_path' => $stagePath, 'sub_stage_file_path' => $subStagePath, 'file_path' => $filePath, 'file_name' => $fileName, 'created_at' => $now];
            if(LoginTeam::uploadChapter($uploadArray)) {
                flash('File Uploaded');
            }
        } else {
            echo "Unable to Move";
        }

        return redirect()->back();
    }

    public function journalList($clientid) {
        // $journal = LoginTeam::getAllJournalCount($clientid);
        $journal = Client::getAllJournalByClientId($clientid);
        $clientData = Client::getClientById($clientid);
        $clients = Client::getAllClientCount();
        $stages = LoginTeam::getArticleStage();
        return view('loginteam.journal', compact('journal', 'clientData', 'clients', 'stages'));
    }

    public function bookListData($clientid, $journalid) {
        $book = Client::getAllBookByClientId($clientid, $journalid);
        $clientData = Client::getClientById($clientid);
        $journalData = Client::getJournalById($journalid);
        $clients = Client::getAllClientCount();
        $stages = LoginTeam::getArticleStage();
        $teamStages = LoginTeam::getTeamStage();
        return view('loginteam.book', compact('book', 'clientData', 'journalData', 'clients', 'stages', 'teamStages'));
    }

    public function chapterList($clientid, $journalid, $bookid) {
        $chapter = LoginTeam::getAllChapter($clientid, $journalid, $bookid);
        $ceusers = CopyEditing::getCopyEditingUsers();
        $clientData = Client::getClientById($clientid);
        $journalData = Client::getJournalById($journalid);
        $bookData = LoginTeam::getBookById($bookid);
        $clients = Client::getAllClientCount();
        $stages = LoginTeam::getArticleStage();
        return view('loginteam.chapterlist', compact('chapter', 'clientData', 'journalData', 'bookData', 'clients', 'stages', 'ceusers'));    
    }

    public function stageList($clientid, $journalid, $bookid, $chapterid) {
        $articleStage = LoginTeam::getAllChapterStage($clientid, $journalid, $bookid, $chapterid);
        $clientData = Client::getClientById($clientid);
        $journalData = Client::getJournalById($journalid);
        $bookData = LoginTeam::getBookById($bookid);
        $chapterData = LoginTeam::getChapterById($chapterid);
        $clients = Client::getAllClientCount();
        $stages = LoginTeam::getArticleStage();
        return view('loginteam.stage', compact('articleStage', 'clientData', 'journalData', 'bookData', 'chapterData', 'clients', 'stages'));    
    }

    public function fileList($clientid, $journalid, $bookid, $chapterid, $stageid) {
        $articleStage = LoginTeam::getAllChapterStageFiles($clientid, $journalid, $bookid, $chapterid, $stageid);
        $clientData = Client::getClientById($clientid);
        $journalData = Client::getJournalById($journalid);
        $bookData = LoginTeam::getBookById($bookid);
        $chapterData = LoginTeam::getChapterById($chapterid);
        $stageData = LoginTeam::getSubStageById($stageid);
        $clients = Client::getAllClientCount();
        $stages = LoginTeam::getArticleStage();
        return view('loginteam.files', compact('articleStage', 'clientData', 'journalData', 'bookData', 'chapterData', 'stageData', 'clients', 'stages'));
    }



    public static function password_reset() {
      
    	$clients = Client::getAllClient();
    	$result = LoginTeam::getChapter();
        $types = Client::getType();

        return view('auth.reset', compact('result', 'clients', 'types'));
    }

   public static function reset_password(Request $request) {
    $password_regenerate ='';
    $user = User::where('email', '=', Input::get('email'))->first();
    $msg = ($user === null)? "This is not authorized email Id" : "Password Sent your register email id"; 
    \Session::flash('message', $msg);
    if($user !== null) {
           $password_regenerate = Role::password_encrptstring();
           $password = bcrypt($password_regenerate);

           $user_Details = Role::getUserDetails(Input::get('email'));

           $datas = array(
            'data-password' =>$password_regenerate,
            'data-username' =>$user_Details->name,
            'data-empid' => $user_Details->emp_id,
            'data-department' =>$user_Details->department,
            //'data-manager' =>$user_Details->group_email,
            'data-manager' =>$user_Details->email
            
        );
        $email_array = array(
            'template_name' =>'emails.forget_password',
            'Subject' =>'Compuscript Forget Password',
            'datas' =>$datas
        );

      //  echo '<pre>'; print_r($email_array);
        //exit;
        
        $email_send = Role::common_emails($email_array);
        
         DB::table('users')->where('email',Input::get('email'))->update(['password' => bcrypt($password_regenerate)]); 


    } 

     return redirect()->back();

   }



   /**
    * While Employee working in Holidays Update the Project Manager Status "Accept / Reject" 
    * After Update the status email trigger through the respective Employee
    * Author : Muhammed Gani
    */

    public static function holidayempstatus() {       

        $mgf_status = request()->segment(2);
        // $encrypted = Crypt::encrypt('Hello, Universe');
        // Decrypt the $encrypted message.
        $message   = Crypt::decrypt($mgf_status);
        $status_value = explode("~~",$message); 
        DB::table('entrance_logs')
        ->where('user_id',$status_value[1])        
        ->whereRaw('Date(loged_in_at) = CURDATE()')
        ->update(['emp_wrk_status' => $status_value[0]]);  

        DB::table('users')
        ->where('id',$status_value[1]) 
        ->update(['emp_wrk_status' => $status_value[0]]);  

         /**
         * Email trigger to the respective employee
         * Author : Muhammed Gani
         */

        $user_Details = Role::getUserDetailsByUserId($status_value[1]);

        $datas = array(         
         'data-username' =>$user_Details->name,
         'data-empid' => $user_Details->emp_id,
         'data-department' =>$user_Details->department,
         'data-manager' =>$user_Details->group_email,
         'data-manager-response' => $status_value[0],
         'data-empemailid' => $user_Details->email,
        );
        $email_array = array(
            'template_name' =>'emails.manager_email_response',
            'Subject' =>'Compuscript  Holiday Work Approved Status',
            'datas' =>$datas
        );
        
        $email_send = Role::common_emails($email_array);
        return view('emails.manager_response');

    }

   
}

