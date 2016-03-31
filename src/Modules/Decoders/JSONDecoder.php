<?php namespace OtherCode\Rest\Modules\Decoders;


/**
 * Class JSONDecoder
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @version 1.0
 * @package OtherCode\Rest
 */
class JSONDecoder extends BaseDecoder
{
    /**
     * The content type that trigger the decoder
     * @var string
     */
    protected $contentType = 'application/json';

    /**
     * Decode the data of a request
     * @return mixed
     */
    protected function decode()
    {
        /**
         * Preform the actual decode
         */
        $this->body = json_decode($this->body);

        /**
         * set the new error code and message
         */
        $this->error->code = json_last_error();

        switch (json_last_error()) {
            case JSON_ERROR_DEPTH:
                $this->error->message = 'The maximum stack depth has been exceeded';
                break;
            case JSON_ERROR_STATE_MISMATCH:
                $this->error->message = 'Invalid or malformed JSON';
                break;
            case JSON_ERROR_CTRL_CHAR:
                $this->error->message = 'Control character error, possibly incorrectly encoded';
                break;
            case JSON_ERROR_SYNTAX:
                $this->error->message = 'Syntax error';
                break;
            case JSON_ERROR_UTF8:
                $this->error->message = 'Malformed UTF-8 characters, possibly incorrectly encoded';
                break;
        }
    }
}