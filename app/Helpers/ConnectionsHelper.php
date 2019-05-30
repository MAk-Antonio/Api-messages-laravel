<?php
use App\Users;
use App\Connections;
class ConnectionsHelper
{
    protected $users;
    protected $connections;
    public function __construct(Users $users,Connections $connections)
    {
        $this->users = $users;
        $this->connections = $connections;
    }

    public function prepareData($request,$users,$id)
    {
        $data = [];
        foreach ($users as $user){
            $user = $this->findUser($user);
            if($user){
                $request['user_id'] = $user;
                $data[$user] = $request;
            }
        }
        return $data;
    }
    public function generateConnId($id,$users)
    {
        $user = $this->users->find($id)->first();
        if($user){
            $connectionKey = $user->connection_key;
            $offset = strlen($connectionKey)/2;
            $key = substr($connectionKey,0,$offset);
            foreach ($users as $user){
                $key .= $user;
            }
            $key .= $key = substr($connectionKey,$offset);
            return substr($key,0,250);
        }
        return false;
    }
    public function verifyPossibleInstance($connection,$id)
    {
        $connection = $this->connections->all()
            ->where('connection_id','=',$connection)
            ->where('user_id','=',$id);
        if(count($connection)>0){
            return $connection->first()->id;
        }
        return true;
    }
    public function validateConnectionForUser($id,$connection)
    {

        $connection = $this->connections->
            where('id',$connection)
            ->where('user_id','=',$id)->first();

        return $connection;
    }
    public function validateConnectionsForUser($id)
    {
        $connection = $this->connections->all()
            ->where('user_id','=',$id);
        if(count($connection)>0){
            return true;
        }
        return false;
    }
    public function findUser($id)
    {
        $user = $this->users->where('identifier',$id)->orWhere('id',$id)->first();
        if(!is_null($user)){
            return $user->id;
        }
        return false;
    }
}
