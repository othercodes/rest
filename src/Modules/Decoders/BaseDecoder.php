<?php

namespace OtherCode\Rest\Modules\Decoders;

/**
 * Class BaseDecoder
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @version 1.0
 * @package OtherCode\Rest\Modules\Decoders
 *
 * @property int $code
 * @property string $content_type
 * @property string $charset
 * @property string $body
 * @property \OtherCode\Rest\Payloads\Headers $headers
 * @property \OtherCode\Rest\Core\Error $error
 * @property array $metadata
 */
abstract class BaseDecoder extends \OtherCode\Rest\Modules\BaseModule implements \OtherCode\Rest\Modules\Decoders\DecoderInterface
{
    /**
     * The content type that trigger the decoder
     * @var string
     */
    protected $contentType = 'text/plain';

    /**
     * Run the main decode method
     */
    public function run()
    {
        $body = $this->body;
        $content_type = $this->content_type;
        if (!empty($body) && isset($content_type)) {

            if ($this->contentType == $content_type) {
                $this->decode();
            }
        }
    }
}