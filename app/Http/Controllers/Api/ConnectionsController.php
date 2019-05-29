<?php

namespace App\Http\Controllers\Api;
use App\Connections;
use App\Messages;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class ConnectionsController extends Controller
{
    private $connections;
    private $request;
    private $requestIp;
    public function __construct(Connections $connections, Request $request)
    {
        $this->connections = $connections;
        $this->request = $request;
        $this->requestIp = str_replace('.','',$request->ip());
    }
    public function index()
    {
        $ip = $this->requestIp;
            $collection = $this->connections->all()->where('user_id','=',$ip);
        $data = ['data' => $collection];
        return response()->json($data);
    }
    public function dev()
    {
        $collection = $this->connections->all();
        $data = ['data' => $collection];
        return response()->json($data);
    }
    public function destroy($id)
    {
        $this->connections->find($id)->delete();
    }
}
