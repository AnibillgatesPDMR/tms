<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use File;

class Client extends Model
{
    public static function getClient() {
    	$client = DB::table('client')
            ->join('users', 'users.id', '=', 'client.created_by')
            ->join('client_type', 'client.type', '=', 'client_type.id')
            ->select('client.*', 'users.name', 'client_type.type')
            ->orderBy('client.created_at', 'desc')
            ->paginate(10);
		return $client;
    }

    public static function getAllClient() {
    	$client = DB::table('client')->join('users', 'users.id', '=', 'client.created_by')->select('client.*', 'users.name')->get();
		return $client;
    }

    public static function getAllClientCount() {
        $client = DB::table('client')
        ->join('journal', 'client.id', '=', 'journal.client_id')
        ->select('client.id as id', 'client.client_name', DB::raw("count(journal.client_id) as count"))
        ->groupBy('client.id')
        ->get();
        return $client;
    }

    public static function getAllBookCount() {
        $book = DB::table('book')->count();
        return $book;
    }

    public static function getClientById($id)
    {
    	$client = DB::table('client')->where('id', '=', $id)->first();
		return $client;
    }

    public static function createClient($type, $clientName, $path, $createdBy)
    {
    	$now = date("Y-m-d h:i:s");
    	$id = DB::table('client')->insertGetId(['type' => $type, 'client_name' => $clientName, 'file_path' => $path, 'created_by' => $createdBy, 'created_at' => $now]);
        return $id;
    }

    public static function createJournal($type, $clientId, $journal, $path, $createdBy)
    {
    	$now = date("Y-m-d h:i:s");
    	$id = DB::table('journal')->insertGetId(['type' => $type, 'client_id' => $clientId, 'journal_name' => $journal, 'file_path' => $path, 'created_by' => $createdBy, 'created_at' => $now]);
        return $id;
    }

    public static function getJournal()
    {
    	$journal = DB::table('journal')
            ->join('client', 'journal.client_id', '=', 'client.id')
            ->join('users', 'users.id', '=', 'journal.created_by')
            ->join('client_type', 'client_type.id', '=', 'journal.type')
            ->select('journal.id', 'journal.journal_name', 'client.client_name', 'journal.created_at', 'users.name', 'client_type.type')
            ->orderBy('journal.created_at', 'desc')
            ->paginate(10);
   		return $journal;
    }

    public static function getAllJournal()
    {
    	$journal = DB::table('journal')->select('journal.id', 'journal.journal_name', 'journal.created_at')->get();
   		return $journal;
    }

    public static function getAllJournalByClientId($clientId)
    {
        $journal = DB::table('journal')
            ->join('users', 'users.id', '=', 'journal.created_by')
            ->join('client_type', 'client_type.id', '=', 'journal.type')
            ->select('journal.id', 'journal.journal_name', 'journal.created_at', 'users.name', 'client_type.type')
            ->where('client_id', '=', $clientId)->paginate(10);
        return $journal;
    }

    public static function getAllBookByClientId($clientId, $journalId)
    {
        $journal = DB::table('book')
            ->join('users', 'users.id', '=', 'book.created_by')
            ->join('client_type', 'client_type.id', '=', 'book.type')
            ->select('book.id', 'book.book_name', 'book.created_at', 'users.name', 'client_type.type', 'book.assign_to')
            ->where('client_id', '=', $clientId)
            ->where('journal_id', '=', $journalId)
            ->paginate(10);
        return $journal;
    }

    public static function getJournalByClientId($clientId)
    {
    	$journal = DB::table('journal')->select('journal.id', 'journal.journal_name')->where('client_id', '=', $clientId)->get();
   		return $journal;
    }

    public static function getJournalById($id)
    {
    	$journal = DB::table('journal')->join('client', 'journal.client_id', '=', 'client.id')
            ->select('journal.id', 'journal.client_id', 'journal.journal_name', 'client.client_name', 'journal.created_at', 'journal.file_path')
            ->where('journal.id', '=', $id)
            ->first();
   		return $journal;
    }

    public static function updateJournal($clientId, $journal, $path, $id)
    {
    	$journal = DB::table('journal')
            ->where('id', $id)
            ->update(['client_id' => $clientId, 'journal_name' => $journal, 'file_path' => $path]);
        return $journal;
    }

    public static function deleteJournal($id)
    {
    	$journal = DB::table('journal')->where('id', '=', $id)->first();
    	chmod($journal->file_path, 0777);
    	if (unlink($journal->file_path)) {
    		$delJournal = DB::table('journal')->where('id', '=', $id)->delete();
    		return true;	
    	} else {
    		return false;
    	}
    }

    public static function getType() {
        $clientType = DB::table('client_type')->select('*')->get();
        return $clientType;
    }

    public static function getClientByType($type) {
        $clientType = DB::table('client')
                    ->join('client_type', 'client.type', '=', 'client_type.id')
                    ->select('client.*')->where('client_type.id', '=', $type)->get();
        return $clientType;
    }

    public static function getStage() {
        $stage = DB::table('stages')->select('stage')->get();
        return $stage;    
    }

    public static function getClientByName($name, $type) {
        $client = DB::table('client')->select('client_name')->where('client_name', '=', $name)->where('type', '=', $type)->get();
        return $client;
    }

    public static function getJournalByName($name, $type, $client) {
        $journal = DB::table('journal')->select('journal_name')->where('journal_name', '=', $name)->where('type', '=', $type)->where('client_id', '=', $client)->get();
        return $journal;    
    }

    public static function getBookByName($name, $type, $client, $journal) {
        $book = DB::table('book')->select('book_name')->where('book_name', '=', $name)->where('type', '=', $type)->where('client_id', '=', $client)->where('journal_id', '=', $journal)->get();
        return $book;    
    }

    public static function getFilePath($type) {
        $file = DB::table('client_type')->select('file_path')->where('id', '=', $type)->first();
        return $file;    
    }
}
