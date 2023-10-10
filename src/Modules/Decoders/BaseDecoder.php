<?php

namespace OtherCode\Rest\Modules\Decoders;

use OtherCode\Rest\Core\Error;
use OtherCode\Rest\Modules\BaseModule;
use OtherCode\Rest\Payloads\Headers;

/**
 * Class BaseDecoder
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @package OtherCode\Rest\Modules\Decoders
 *
 * @property int $code
 * @property string $content_type
 * @property string $charset
 * @property string $body
 * @property Headers $headers
 * @property Error $error
 * @property array $metadata
 */
abstract class BaseDecoder extends BaseModule implements DecoderInterface
{
    /**
     * The content type that trigger the decoder
     * @var string
     */
    protected string $contentType = 'text/plain';

    /**
     * Run the main decode method
     */
    public function run()
    {
        $body = $this->body;
        $content_type = $this->content_type;
        if (!empty($body) && isset($content_type) && $this->contentType == $content_type) {
            $this->decode();
        }
    }
}
