<?php

return [
    /*
      |--------------------------------------------------------------------------
      | Validation Language Lines
      |--------------------------------------------------------------------------
      |
      | The following language lines contain the default error messages used by
      | the validator class. Some of these rules have multiple versions such
      | as the size rules. Feel free to tweak each of these messages here.
      |
     */

    'accepted' => 'El :attribute debe ser aceptado',
    'accepted_if' => 'El :attribute debe aceptarse cuadno :other es :value',
    'active_url' => 'El :attribute no es una URL valida',
    'after' => 'El :attribute debe ser una fecha posterior a :date',
    'after_or_equal' => 'El :attribute debe ser una fecha posterior o igual a :date.',
    'alpha' => 'El :attribute solo debe contener letras',
    'alpha_dash' => 'El :attribute solo debe contener letras, numeros, guiones y guiones bajos',
    'alpha_num' => 'El :attribute solo debe contener letras y numeros',
    'array' => 'El :attribute debe ser un arreglo',
    'before' => 'El :attribute debe ser una fecha anterior a :date.',
    'before_or_equal' => 'El :attribute debe ser una fecha anterior o igual a :date',
    'between' => [
        'numeric' => 'El :attribute debe estar entre :min y :max',
        'file' => 'El :attribute debe estar entre :min y :max kilobytes',
        'string' => 'El :attribute debe estar entre :min y :max caracteres',
        'array' => 'El :attribute debe estar entre :min y :max elementos',
    ],
    'boolean' => 'El :attribute debe ser verdadero o falso',
    'confirmed' => 'La confirmacion del :attribute no coincide',
    'current_password' => 'La contraseña es incorrecta',
    'date' => 'El :attribute no es una fecha valida',
    'date_equals' => 'El :attribute debe ser una fecha igual a :date',
    'date_format' => 'El :attribute no coincidde con el formato :format',
    'declined' => 'El :attribute fue rechazado',
    'declined_if' => 'El :attribute debe rechazarse cuando :other es :value',
    'different' => 'El :attribute y :other deben ser diferentes',
    'digits' => 'El :attribute debe ser :digits digitos',
    'digits_between' => 'El :attribute debe estar entre :min y :max digitos',
    'dimensions' => 'El :attribute tiene dimensiones de imagen no validas',
    'distinct' => 'El campo :attribute tiene un valor duplicado',
    'email' => 'El :attribute debe ser una direccion de correo electronico valida',
    'ends_with' => 'El :attribute debe terminar con uno de los siguientes valores: :values',
    'enum' => 'El :attribute seleccionado no es valido',
    'exists' => 'El :attribute seleccionado no es valido',
    'file' => 'El :attribute debe ser un archivo',
    'filled' => 'El campo :attribute debe tener un valor',
    'gt' => [
        'numeric' => 'El :attribute debe ser mayor que :value',
        'file' => 'El :attribute debe ser mayor que :value kilobytes',
        'string' => 'El :attribute debe ser mayor que :value caracteres',
        'array' => 'El :attribute debe tener mas de :value elementos',
    ],
    'gte' => [
        'numeric' => 'El :attribute debe ser mayor o igual que :value',
        'file' => 'El :attribute debe ser mayor o igual que :value kilobytes',
        'string' => 'El :attribute debe ser mayor o igual que :value caracteres',
        'array' => 'El :attribute debe tener :value elementos o mas',
    ],
    'image' => 'El :attribute debe ser una imagen',
    'in' => 'El :attribute seleccionado no es valido',
    'in_array' => 'El campo :attribute no existe en :other',
    'integer' => 'El :attribute debe ser un numero entero',
    'ip' => 'El :attribute debe ser una direccion IP valida',
    'ipv4' => 'El :attribute debe ser una direccion IPv4 valida',
    'ipv6' => 'El :attribute debe ser una direccion IPv6 valida',
    'json' => 'El :attribute debe ser un cadena JSON valida',
    'lt' => [
        'numeric' => 'El :attribute debe ser menor que :value',
        'file' => 'El :attribute debe ser inferior :value kilobytes',
        'string' => 'El :attribute debe ser menor :value caracteres',
        'array' => 'El :attribute debe tener menos de :value elementos',
    ],
    'lte' => [
        'numeric' => 'El :attribute debe ser menor o igual que :value',
        'file' => 'El :attribute debe ser menor o igual que :value kilobytes',
        'string' => 'El :attribute debe ser menor o igual que :value caracteres',
        'array' => 'El :attribute no debe tener mas de :value elementos',
    ],
    'mac_address' => 'El :attribute debe ser una direccion MAC valida',
    'max' => [
        'numeric' => 'El :attribute no debe ser mayor que :max',
        'file' => 'El :attribute no debe ser mayor que :max kilobytes',
        'string' => 'El :attribute no debe ser mayor que :max caracteres',
        'array' => 'El :attribute no debe tener mas de :max elementos',
    ],
    'mimes' => 'El :attribute debe ser un archivo de tipo: :values',
    'mimetypes' => 'El :attribute debe ser un archivo de tipo: :values',
    'min' => [
        'numeric' => 'El :attribute debe ser al menos :min',
        'file' => 'El :attribute debe tener al menos :min kilobytes',
        'string' => 'El :attribute debe tener al menos :min caracteres',
        'array' => 'El :attribute debe tener al menos :min elementos',
    ],
    'multiple_of' => 'El :attribute debe ser un multiplo de :value',
    'not_in' => 'El :attribute seleccionado no es valido',
    'not_regex' => 'El formato del :attribute no es valido',
    'numeric' => 'El :attribute debe ser un numero',
    'password' => 'La contraseña es incorrecta',
    'present' => 'El campo :attribute debe estar presente',
    'prohibited' => 'El cmapo :attribute esta prohibido',
    'prohibited_if' => 'El campo :attribute esta prohibido cuando :other es :value',
    'prohibited_unless' => 'El campo :attribute esta prohibido a menos que :other este en :values',
    'prohibits' => 'El campo :attribute prohibe que :other este presente',
    'regex' => 'El formato :attribute no es valido',
    'required' => 'El campo :attribute es obligatorio',
    'required_array_keys' => 'El campo :attribute debe contener: :values',
    'required_if' => 'El campo :attribute es obligatorio cuando :other es :value',
    'required_unless' => 'El campos :attribute es obligatorio a menos que :other este en :values',
    'required_with' => 'El campo :attribute es obligatorio cuando :values esta presente',
    'required_with_all' => 'El campo :attribute es obligatorio cuando :values estan presentes',
    'required_without' => 'El campo :attribute es obligatorio cuando :values no esta presente',
    'required_without_all' => 'El campo :attribute es obligatorio cuando ninguno de los :values esta presente',
    'same' => 'El :attribute y :other deben coincidir',
    'size' => [
        'numeric' => 'El :attribute debe ser :size',
        'file' => 'El :attribute debe ser :size kilobytes',
        'string' => 'El :attribute debe ser :size caracteres',
        'array' => 'El :attribute debe contener :size elementos',
    ],
    'starts_with' => 'El :attribute debe comenzar con uno de los siguientes: :values',
    'string' => 'El :attribute debe ser una cadena',
    'timezone' => 'El :attribute debe ser una zona horaria valida',
    'unique' => 'El :attribute ya ha sido tomado',
    'uploaded' => 'El :attribute no se pudo cargar',
    'url' => 'El :attribute debe ser una URL valida',
    'uuid' => 'El :attribute debe ser un UUID valido',
    /*
      |--------------------------------------------------------------------------
      | Custom Validation Language Lines
      |--------------------------------------------------------------------------
      |
      | Here you may specify custom validation messages for attributes using the
      | convention "attribute.rule" to name the lines. This makes it quick to
      | specify a specific custom language line for a given attribute rule.
      |
     */
    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],
    /*
      |--------------------------------------------------------------------------
      | Custom Validation Attributes
      |--------------------------------------------------------------------------
      |
      | The following language lines are used to swap our attribute placeholder
      | with something more reader friendly such as "E-Mail Address" instead
      | of "email". This simply helps us make our message more expressive.
      |
     */
    'attributes' => [],
];
