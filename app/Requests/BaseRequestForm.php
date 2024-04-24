<?php

namespace App\Requests;

use Illuminate\Http\Request;
use Validator;


abstract class BaseRequestForm
{
    protected $_request;
    /**
     * @var bool
     */
    private $status=true;
    /**
     * @var array
     */
    private $errors=[];

    abstract public function rules(): array;


    public function __construct(Request $request = null, $forceDie = true)
    {



        if (!is_null($request)) {
            $this->_request = $request;
            $rules = $this->rules();

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                if ($forceDie) {
                    $error=$validator->errors()->toArray();
                    //return response($error,406);
                    $error = \Illuminate\Validation\ValidationException::withMessages($error);
                    throw $error;
                }else{
                    $this->status = false;
                    $this->errors  =$validator->errors()->toArray();
                }

            }


        }
    }

    /**
     * @return bool
     */
    public function isStatus(): bool
    {
        return $this->status;
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }


    public function request()
    {
        return $this->_request;
    }
}
