<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

    Route::group( ['middleware' => ['auth']], function() {
    Route::resource('users', 'UserController');
    Route::resource('roles', 'RoleController');
    Route::resource('clients', 'ClientController');
    Route::resource('login', 'LoginTeamController');

    /** Holiday Modules */
    Route::get('holidays', 'UserController@holidayslist');
    Route::get('holidays/add/holiday', 'UserController@holidays');  
    Route::post('holidays/add/holiday', 'UserController@holidays'); 
    
    Route::post('holiday/insertholiday', 'UserController@holidaystore'); 
    
    
    
    

    Route::get('holidays/{id}/edit', 'UserController@holidays_edit'); 
    Route::get('deleteholidays/{id}', 'UserController@holidays_delete'); 

    /** Holiday Modules End */

      /** Ticket Module Start */
     
    Route::get('tickets', 'UserController@tickets');
    Route::get('tickets/add/ticket', 'UserController@ticket_list');
    Route::post('tickets/inserttickets', 'UserController@ticketstore');   
    Route::get('ticket_assign_department/{id}/{department}', 'UserController@ticket_assign_department'); 
Route::get('compus_assign_status/{id}/{status}', 'UserController@ticket_compus_assign_status'); 
    /** Tickets Moduels */    







    Route::get('holidays/{id}/edit', 'UserController@holidays_edit'); 


    /** Change Password  */

    Route::get('change_password', 'UserController@change_password'); 
     Route::post('update_password', 'UserController@update_password');

    /** Change Password End */

    



    /** User Leave Modules */

    Route::get('leavedashboard', 'UserController@leavedashboard');
    Route::get('leave/add/leave', 'UserController@leaves');
    Route::get('leave/approve', 'UserController@leaveApprove');
    Route::get('leave-approve/{id}/{leaveid}/{userid}', 'UserController@userLeaveApprove');  
    Route::get('leave/insertleave', 'UserController@leavestore'); 

    Route::get('userleave/{id}/edit', 'UserController@user_leaveedit'); 

    Route::get('deleteuserleave/{id}/{userid}', 'UserController@userleave_delete'); 

    Route::get('acceptuserleave/{id}/{userid}', 'UserController@acceptuserleave');

    Route::get('leavebalance', 'UserController@leavebalance');


    Route::get('leave_acceptbulk/{id}', 'UserController@leave_acceptbulk_mgr'); 
    
    Route::get('leave_rejectbulk/{id}', 'UserController@leave_rejectbulk'); 



    Route::get('leavebalance_details/{id}', 'UserController@leavebalance_details');

    /** User Leave Modules End */
    
    
    /** Breaking Time Module Start */
    
    Route::get('addbreakinghours', 'UserController@breakinghours');
    Route::get('breaktimeinsert', 'UserController@breakstore'); 
    
    
    /** Breaking Time Module End */


    /** Forget Login Modules Start */

    Route::get('forgetlogin', 'UserController@forget_loginlist');
    Route::post('forgetlogin/insertforgetlogin', 'UserController@insertforgetlogin');
    Route::get('forgetlogin/{id}/edit', 'UserController@forgetlogin_edit'); 
    Route::get('forgetlogin_accept/{id}', 'UserController@forgetlogin_accept_user');    

   






    /** Manager Email id Modules
     * Author : Muhammed Gani
     */

    
    Route::get('manageremail/add/mgremail', 'UserController@mgremaillist');  
    Route::post('mgremailid/insertmgremailid', 'UserController@insertmgremailid');
    Route::post('deletemgr/{id}', 'UserController@deletemgremailid');
    Route::get('manageremailid/{id}/edit', 'UserController@manageremailidedit'); 

    /** Manager Email id Modules End */   
    
    

    /** Department Modules */
    Route::get('departmentlist', 'UserController@departmentlist');  
    Route::get('department/add/department', 'UserController@department');  
    Route::post('department/insertdepartment', 'UserController@insertdepartment');
    Route::get('department/{id}/edit', 'UserController@departmentEdit');  
    Route::get('deletedepartment/{id}', 'UserController@deletedepartment');
   //   


    /** Department Modules End */


     


   /** Tracking working Hours  */

   Route::get('trackingworkinghours', 'UserController@trackingworkinghours');

   Route::post('trackingsearch', 'UserController@trackingsearch');

   /** Tracking working Hours End */

   /** Report Module Start */

   Route::get('reportdashboard', 'UserController@reportdashboard');  
   Route::get('reports', 'UserController@reports');   
   Route::post('reports', 'UserController@reports');

   /** Report Module End */

   /** Attendance Details */

   Route::get('attentance', 'UserController@attentance');   
   Route::post('attentance', 'UserController@attentance');      



   /** Attendance Details */  


   /** Report Employee Leave Start */

   Route::get('emplleavereports', 'UserController@emplleavereports');  
   Route::post('emplleavereports', 'UserController@emplleavereports');

   /** Report Employee Leave End */


    Route::get('users/view/{id}', 'UserController@viewUser');
    Route::get('users/add/user', 'UserController@users');

    Route::get('users/shift/{id}', 'UserController@shifttime');

    Route::post('/users/insertshit', 'UserController@insertshift');

    //Start : Client module
    Route::get('/clients/home/dashboard', 'ClientController@dashBoard');
    Route::get('/clients/journal', 'ClientController@show');
    Route::post('/journal/create', 'ClientController@createJournal');
    Route::post('/journal/update', 'ClientController@updateJournal');
    Route::get('/clients/journal/edit/{id}', 'ClientController@getJournal');
    Route::get('/clients/journal/delete/{id}', 'ClientController@deleteJournal');
    Route::post('/clients/client-by-type', 'ClientController@clientByType');
    //End : Client module

    //Start : Login team module
    Route::post('/login/chapter/client-by-type', 'ClientController@clientByType');
    Route::get('/login/home/dashboard', 'LoginTeamController@dashBoard');
    Route::post('/login/chapter/journal', 'LoginTeamController@getClientJournal');
    Route::post('/login/client/journal', 'LoginTeamController@getClientJournal');
    Route::post('/login/book/journal', 'LoginTeamController@getClientJournal');
    Route::post('/login/client/book', 'LoginTeamController@getClientBook');
    Route::post('/login/chapter/book', 'LoginTeamController@getClientBook');
    Route::post('/login/client/chapter', 'LoginTeamController@getClientChapter');
    Route::post('/login/client/stage', 'LoginTeamController@getChapterStage');
    Route::post('/book/create', 'LoginTeamController@createBook');
    Route::post('/chapter/create', 'LoginTeamController@createChapter');
    Route::post('/chapter/upload', 'LoginTeamController@chapterUpload');
    Route::get('/login/book/list', 'LoginTeamController@bookList');
    Route::get('/login/chapter/list', 'LoginTeamController@show');
    Route::get('/login/client/list', 'LoginTeamController@upload');
    Route::get('/login/journal/list/{id}', 'LoginTeamController@journalList');
    Route::get('/login/book/list/{id}/{journalid}', 'LoginTeamController@bookListData');
    Route::get('/login/chapter/list/{id}/{journalid}/{bookid}', 'LoginTeamController@chapterList');
    Route::get('/login/stage/list/{clientid}/{journalid}/{bookid}/{chapterid}', 'LoginTeamController@stageList');
    Route::get('/login/file/list/{clientid}/{journalid}/{bookid}/{chapterid}/{stageid}', 'LoginTeamController@fileList');
    Route::post('/login/client/client-by-type', 'ClientController@clientByType');
    Route::post('/login/book/client-by-type', 'ClientController@clientByType');
    Route::post('/check-client-name', 'ClientController@checkClientName');
    Route::post('/clients/check-journal-name', 'ClientController@checkJournalName');
    Route::post('/login/book/check-book-name', 'ClientController@checkBookName');
    //End : Login team module

    //Start : Copy Editing team module
    Route::get('/copy/home/dashboard', 'MoveController@dashBoard');
    Route::post('/book/assign', 'MoveController@bookAssign');
    Route::get('/copy/jobs/list', 'CopyEditingController@jobsList');
    Route::get('/copy/jobs/chapter/{id}', 'CopyEditingController@jobChapter');
    Route::post('/user/assign', 'CopyEditingController@userAssign');
    Route::get('/copy/myjobs/list', 'CopyEditingController@myJobsList');
    Route::get('/copy/stage/list/{id}', 'CopyEditingController@stageList');
    Route::get('/copy/file/list/{chapterid}/{stageid}', 'CopyEditingController@fileList');
    //End : Copy Editing team module

    //Start : Pre Editing team module
    Route::get('/pre/home/dashboard', 'PreController@dashBoard');
    Route::get('/pre/jobs/list', 'PreController@jobsList');
    Route::get('/pre/jobs/chapter/{id}', 'PreController@jobChapter');
    Route::post('/user/assign', 'PreController@userAssign');
    Route::get('/pre/myjobs/list', 'PreController@myJobsList');
    Route::get('/pre/stage/list/{id}', 'PreController@stageList');
    Route::get('/pre/file/list/{chapterid}/{stageid}', 'PreController@fileList');
    //End : Pre Editing team module

    //Start : XML team module
    Route::get('/xml/home/dashboard', 'XMLController@dashBoard');
    Route::get('/xml/jobs/list', 'XMLController@jobsList');
    Route::get('/xml/jobs/chapter/{id}', 'XMLController@jobChapter');
    Route::post('/user/assign', 'XMLController@userAssign');
    Route::get('/xml/myjobs/list', 'XMLController@myJobsList');
    Route::get('/xml/stage/list/{id}', 'XMLController@stageList');
    Route::get('/xml/file/list/{chapterid}/{stageid}', 'XMLController@fileList');
    //End : XML team module

    //Start : indd team module
    Route::get('/indd/home/dashboard', 'InddController@dashBoard');
    Route::get('/indd/jobs/list', 'InddController@jobsList');
    Route::get('/indd/jobs/chapter/{id}', 'InddController@jobChapter');
    Route::post('/user/assign', 'InddController@userAssign');
    Route::get('/indd/myjobs/list', 'InddController@myJobsList');
    Route::get('/indd/stage/list/{id}', 'InddController@stageList');
    Route::get('/indd/file/list/{chapterid}/{stageid}', 'InddController@fileList');
    //End : indd team module

    //Start : Epub team module
    Route::get('/epub/home/dashboard', 'EpubController@dashBoard');
    Route::get('/epub/jobs/list', 'EpubController@jobsList');
    Route::get('/epub/jobs/chapter/{id}', 'EpubController@jobChapter');
    Route::post('/user/assign', 'EpubController@userAssign');
    Route::get('/epub/myjobs/list', 'EpubController@myJobsList');
    Route::get('/epub/stage/list/{id}', 'EpubController@stageList');
    Route::get('/epub/file/list/{chapterid}/{stageid}', 'EpubController@fileList');
    //End : Epub team module

    //Start : File dispatch team module
    Route::get('/file/home/dashboard', 'FileController@dashBoard');
    Route::get('/file/jobs/list', 'FileController@jobsList');
    Route::get('/file/jobs/chapter/{id}', 'FileController@jobChapter');
    Route::post('/user/assign', 'FileController@userAssign');
    Route::get('/file/myjobs/list', 'FileController@myJobsList');
    Route::get('/file/stage/list/{id}', 'FileController@stageList');
    Route::get('/file/file/list/{chapterid}/{stageid}', 'FileController@fileList');
    //End : File dispatch team module

    //Start : Graphice team module
    Route::get('/graphice/home/dashboard', 'GraphiceController@dashBoard');
    Route::get('/graphice/jobs/list', 'GraphiceController@jobsList');
    Route::get('/graphice/jobs/chapter/{id}', 'GraphiceController@jobChapter');
    Route::post('/user/assign', 'GraphiceController@userAssign');
    Route::get('/graphice/myjobs/list', 'GraphiceController@myJobsList');
    Route::get('/graphice/stage/list/{id}', 'GraphiceController@stageList');
    Route::get('/graphice/file/list/{chapterid}/{stageid}', 'GraphiceController@fileList');
    //End : Graphice team module
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('password', 'LoginTeamController@password_reset');
Route::post('resetpassword', 'LoginTeamController@reset_password');
Route::get('holidayempstatus/{status}', 'LoginTeamController@holidayempstatus');



/** Cron Job Forget Login User at 10 AM */

Route::get('cronforgetlogin/', 'UserController@user_forgetlogin_email_cron'); 
Route::get('cronforgetlogout/', 'UserController@user_forgetloggedout_email_cron'); 

/** Weekly Report Corn Job URL */

Route::get('cronweeklyreport/', 'UserController@weekly_TimesheetReport'); 

/** Bank / National Holiday Notification send to all employees Cron Jon
 * Author : Muhammed Gani
 */

Route::get('cronbankholidaynotification/', 'UserController@bank_NationalHolidaynotify'); 


/** Cron Job Forget Login User End */    


/**Open exe files */

Route::get('openexefile/', 'UserController@openexefiles'); 
