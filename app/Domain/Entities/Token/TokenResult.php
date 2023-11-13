<?php 
namespace App\Domain\Entities\Token;

use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\AccessorOrder;
/**
 * @AccessorOrder("custom", custom = {"accessToken", "expiresAt"})
 */
class TokenResult {
    /** 
     * @SerializedName("accessToken") 
    */
    protected $accessToken;
    /** 
     * @SerializedName("expiresAt") 
    */
    protected $expiresAt;

    public function __construct($accessToken, $expiresAt){
        $this->accessToken = $accessToken;
        $this->expiresAt = $expiresAt;
    }
 
    public function getAccessToken(){
        return $this->accessToken;
    }
 
    public function setAccessToken($accessToken){
        $this->accessToken = $accessToken;
    }

    public function getExpiresAt(){
        return $this->expiresAt;
    }
    
    public function setExpiresAt($expiresAt){
        $this->expiresAt = $expiresAt;
    }
}