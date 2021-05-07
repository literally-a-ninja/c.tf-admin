<?php

namespace App\Http\Requests;

use App\Definitions\Mission;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;
use JetBrains\PhpStorm\ArrayShape;

class DD20MissionPostRequest extends FormRequest
{
    public function __construct (
        protected Mission $dMission,
        array $query = [],
        array $request = [],
        array $attributes = [],
        array $cookies = [],
        array $files = [],
        array $server = [],
        $content = NULL
    ) {
        parent::__construct ($query, $request, $attributes, $cookies, $files, $server, $content);
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize () : bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    #[ArrayShape([ 'reference' => "string", 'waves' => "string", 'procedure' => "string" ])]
    public function rules () : array
    {
        return [
            'reference' => 'string|required',
            'waves' => 'array|required',
            'procedure' => 'string|required',
        ];
    }

    /**
     * Returns a collection of waves.
     *
     * @return Collection
     */
    public function waves () : Collection
    {
        return collect ($this->post ('waves'))->flip ();
    }

    /**
     * Returns the original wave definition from the economy.
     *
     * @return Mission
     */
    public function definition () : Mission
    {
        $encRef = $this->post ('reference');
        $array = collect(json_decode (base64_decode ($encRef), true));
        $mission = $this->dMission->newInstance ();
        $mission->fill ($array);

        return $mission;
    }
}
