<?php
use \Illuminate\Support\Facades\Hash;
use App\Users;
use Illuminate\Http\Request;
class AuthHelper
{
    private $request;
    private $users;
    public function __construct(Users $users,Request $request)
    {
        $this->users = $users;
        $this->request = $request;
    }
    public function autenticate($response,$create = false,$identifier = null)
    {
        $response['errors'] = [];
        $response['warning'] = [];
        $user = false;
        $userAuth = false;
        $userId = false;
        if(!$this->request->session()->get('autenticated') || !$this->request->session()->get('autenticated_id')){
            if (!isset($response['auth']) && isset($response['auth_type'])){
                // Retorna erro caso definido tipo de autenticação
                $response['errors'][] = 'Não foi definido a autenticação.';
            }elseif(isset($response['auth']) && !isset($response['auth_type'])){
                $response['errors'][] = 'Não foi definido o tipo de autenticação.';
            }elseif(!isset($response['auth']) && !isset($response['auth_type'])){
                if(!$this->request->session()->get('auth_hash')){
                    if ($create){
                        $response['warning'][] = 'Não foi utilizado uma autenticação na requisição, portanto foi gerada uma autenticação';
                        $user = $this->generateAuth('visitor',$identifier);
                        if($user){
                            $userAuth = $user->auth_hash;
                            $userId = $user->id;
                            $response['warning'][''] = 'Usuário Criado';
                            $response['warning']['is_visitor'] = 'true';
                            $response['warning']['visitor_id'] = $userId;
                        }
                    }else{
                        $response['errors'][] = 'Não foi possĩvel autenticar';
                    }
                }else{
                    $response['auth_type'] = 'simple';
                    $response['auth'] = $this->request->session()->get('auth_hash');
                    $user = $this->verifyUser($response,true);
                }
            }else{
                $user = $this->verifyUser($response,true);
                if(is_null($user)){
                   $user = $this->generateAuth($response['auth_type'],$response);
                }
            }
            if($user){
                $userAuth = $user->auth_hash;
                $userId = $user->id;
            }
            $this->request->session()->put('auth_hash',$userAuth);
            $this->request->session()->put('autenticated',true);
            $this->request->session()->put('autenticated_id',$userId);
            $this->request->session()->save();
        }else{
            $userId = $this->request->session()->get('autenticated_id');
        }

        $response['id'] = $userId;
        return $response;
    }
    protected function verifyUser($data,$acceptVisitor = false)
    {
        $types = ['simple'];
        if($acceptVisitor){
            $types[] = 'visitor';
        }
        switch ($data['auth_type']){
            case 'simple':
                if (is_numeric($data['auth'])){
                    $user = $this->users->find($data['auth']);
                    if(is_null($user) || !in_array($user->auth_type,$types)){
                        $user = false;
                    }
                }else{
                    $user = $this->users->where('auth_hash',$data['auth'])
                    ->whereIn('auth_type',$types)->first();
                }
                break;
            case 'default':
                $auth = $data['auth'];
                $user = $this->users->all()
                    ->where('identifier','=',$auth['identifier'])
                    ->where('key','=',$auth['pass']);
                break;
        }
        return $user;
    }
    public function generateAuth($type,$data)
    {
        switch ($type){
            case 'simple':
                $identifier = $data['identifier'];
                $key = $data['pass'];
                break;
            case 'default':
                $identifier = $data['auth']['identifier'];
                $key = $data['auth']['pass'];
                break;
        }
        $identifier = $this->cleanIdentifier($identifier);
        $key = isset($key)?$key:false;
        if($type === 'visitor'){
            $identifier = $this->generateIdentifier($identifier,true);
        }
        if(!$this->canCreateNewUser($identifier))
        {
            $identifier = $this->generateIdentifier($identifier);
        }
        $data['identifier'] = $identifier;
        $data['key'] = $key;
        $data['auth_type'] = $type;
        if(!$key){
            $key = $this->generateRandomString(6);
        }
        $data['auth_hash'] = $this->generateAuthHash($identifier,$key);
        $data['connection_key'] = $this->generateConnectionKey($identifier);
        unset($data['pass']);
        $this->request->request->replace($data);
        $user = $this->users->create($data);
        return $user;
    }
    public function insertInSession($id)
    {
        $user = $this->users->find($id)->first();
        $session = $this->request->session();
        $session->put('auth_hash',$user->auth_hash);
        $session->put('autenticated',true);
        $session->put('autenticated_id',$id);
        $session->save();
    }
    protected function generateIdentifier($identifier,$randomize = false)
    {
        if($randomize){
            $hash = Hash::make($identifier.':'.$this->generateRandomString(12));
        }else{
            $hash = $identifier.'_'.$this->generateRandomString(rand(3,6));
        }
        return $hash;
    }
    protected function canCreateNewUser($identifier){
        $users = $this->users->all()->where('identifier','=',$identifier);
        return (count($users)==0)?true:false;
    }
    public function generateAuthHash($identifier,$key)
    {
        $hash = Hash::make($identifier.':'.$this->generateRandomString(12));
        $hash .=$identifier.':$('.$key;
        $hash = Hash::make($hash).Hash::make($this->generateRandomString(8));
        return substr($hash,0,64);
    }
    public function clearSession()
    {
        $session = $this->request->session();
        $session->regenerate(true);
        $session->save();
    }
    protected function generateConnectionKey($identifier)
    {
        $key = $this->generateRandomString(4).substr($identifier,0,12).$this->generateRandomString(16);
        $key = substr(Hash::make($key),0,32);
        return $key;
    }
    protected function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    protected function cleanIdentifier($string) {
        $search = ['.','/','-','_','$','%','&',',','"',"'",'*'];
        $string = str_replace($search,'',$string);
        return $string;
    }
}
