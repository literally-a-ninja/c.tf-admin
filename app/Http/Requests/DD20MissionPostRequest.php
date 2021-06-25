<?php

namespace App\Http\Requests;

use App\Definitions\EconMission;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;
use JetBrains\PhpStorm\ArrayShape;

class DD20MissionPostRequest extends FormRequest
{
    public function __construct (
        protected Filesystem $filesystem,
        protected EconMission $econMission,
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
     * Returns indication if loot distributor should be enabled or not.
     *
     * @return bool
     */
    public function shouldProcessLoot () : bool
    {
        return boolval ($this->post ('give_loot', false));
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
     * @param  EconMission  $econMission
     * @return EconMission
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function definition () : EconMission
    {
        $encRef = $this->post ('reference');
        $array = collect (json_decode (base64_decode ($encRef), true));

        return $this->econMission
            ->newInstance ()
            ->fill ($array);
    }
}
