<?php

        function isRequired($value, $key, $checks)
        {
            if(! $value) {
                // probleem
                return 'U heeft geen waarde ingevuld';
            }
        }

        function isNumber($value, $key, $checks)
        {
            if(! is_numeric($value)) {
                // probleem
                return 'U moet een numerieke waarde invoeren';
            }
        }

?>