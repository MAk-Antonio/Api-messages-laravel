<?php

namespace App\Http\Controllers\Api;
use App\Messages;
use App\Connections;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use AuthHelper;
use MessagesHelper;
use ConnectionsHelper;
class MessagesController extends Controller
{
    private $messages;
    private $connections;
    private $request;
    private $requestIp;
    public function __construct(Messages $messages, Connections $connections, Request $request)
    {
        $this->messages = $messages;
        $this->connections = $connections;
        $this->request = $request;
        $this->requestIp = str_replace('.','',$request->ip());
    }
    public function index($connection = null)
    {
        $ip = $this->requestIp;
        $collection = [];
        if(!is_null($connection)){
            $connections = [];
            $connections[] =$this->connections->find($connection);
        } else{
            $connections = $this->connections->all()->where('user_id','=',$ip);
            foreach ($connections as $connection){
                $collection[$connection->id.'-'.$connection->subject] = $this->messages->all()->where('connection','=',$connection->connection_id);
            }
        }
        $data = ['data' => $collection];
        return response()->json($data);
    }
    public function show($id)
    {
        $data = ['data' => $this->messages->find($id)];
        return response()->json($data);
    }
    public function store($instance = null)
    {
        $ip = $this->requestIp;
        $data = $this->request->all();
        if(is_null($instance)){
            $connId = substr($ip,3).rand().substr($ip,0,4);
            if(!isset($data['subject'])){
                $data['subject'] = $connId;
            }
            $instanceData['subject'] = $data['subject'];
            unset($data['subject']);
            $instanceData['connection_id'] = $connId;
            $destinations = $data['destination'];
            if (!is_array($destinations)) {
                $destinations = [$destinations];
            }
            $destinations[] = $ip;
            unset($data['destination']);
            foreach ($destinations as $userKey => $user){
                $instanceData['user_id'] = $user;
                $instance = $this->connections->create($instanceData);
                if($user === $ip){
                    $instance = $instance->id;
                }
            }
        }
        $connection = $this->connections->find($instance);
        $data['connection'] = $connection->connection_id;
        $data['user_id'] = $ip;
        $this->messages->create($data);
        $data = ['connection' => $instance, 'user_id',$ip];
        return response()->json($data);
    }
    public function update($id)
    {
        $data = $this->request->all();
        $message = $this->messages->find($id);
        $message->update($data);
    }
    public function destroy($id)
    {
        $this->messages->find($id)->delete();
    }
    public function dev()
    {
        $ip = $this->requestIp;
        $collection = [];
        $connections = $this->connections->all();
        foreach ($connections as $connection){
            $collection[$connection->id.'-'.$connection->subject] = $this->messages->all()->where('connection','=',$connection->connection_id);
        }
        $data = ['data' => $collection];
        return response()->json($data);
    }
}
