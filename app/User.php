<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Kyslik\ColumnSortable\Sortable;

/**
 * @property int $id
 * @property int $perfiluser_id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $remember_token
 * @property string $tp_user
 * @property string $cs_status
 * @property string $avatar
 * @property string $created_at
 * @property string $updated_at
 * @property Perfiluser $perfiluser
 * @property Mensagem[] $mensagems
 * @property Responsavel[] $responsavels
 * @property RegistroLog[] $registroLogs
 * @property TermosCondicoesUsuario[] $termosCondicoesUsuarios
 * @property Profissional[] $profissionals
 * @property MensagemDestinatario[] $mensagemDestinatarios
 * @property Representante[] $representantes
 * @property Paciente[] $pacientes
 */
class User extends Authenticatable
{
    use Notifiable;
    use Sortable;
    
    public $sortable  = ['id', 'name', 'email', 'tp_user', 'cs_status', 'perfiluser_id'];
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password', 'access_token', 'tp_user', 'cs_status'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password', 'access_token', 'remember_token'];
    
    public function perfiluser()
    {
    	return $this->belongsTo('App\Perfiluser');
    }
    
    public function paciente(){
        return $this->hasOne('App\Paciente');
    }
    
    public function profissional(){
        return $this->hasOne('App\Profissional');
    }
    
    public function responsavel()
    {
        return $this->hasMany('App\Responsavel');
        
    }
    
    public function mensagems(){
        return $this->hasMany('App\Mensagem', 'remetente_id');
    }
    
    public function destinatarios(){
        return $this->hasMany('App\MensagemDestinatario', 'destinatario_id');
    }

	public function getAuthPassword(){
		return $this->access_token;
	}
}