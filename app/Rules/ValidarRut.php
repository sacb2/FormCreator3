<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidarRut implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $rut=strtoupper(str_replace('-','',$value));

		$sub_rut=substr($rut,0,strlen($rut)-1);

		$sub_dv=substr($rut,-1);

		$x=2;

		$s=0;

		for ( $i=strlen($sub_rut)-1;$i>=0;$i-- )

		{

			if ( $x >7 )

			{

				$x=2;

			}

			$s += $sub_rut[$i]*$x;

			$x++;

		}

		$dv=11-($s%11);

		if ( $dv==10 )

		{

			$dv='K';

		}

		if ( $dv==11 )

		{

			$dv='0';

		}

		if ( $dv==$sub_dv )

		{

			return true;

		}

		else

		{

			return false;

		}
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'newuser.nombre4';
    }
}
