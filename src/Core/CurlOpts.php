<?php

namespace OtherCode\Rest\Core;

/**
 * Class CurlOpts
 * @see http://php.net/manual/es/function.curl-setopt.php
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @version 1.0
 * @package OtherCode\Rest\Core
 */
abstract class CurlOpts
{

    /**
     * TRUE to automatically set the Referer: field in requests where it
     * follows a Location: redirect.
     * @var boolean
     */
    public $autoreferer;

    /**
     * TRUE to return the raw output when CURLOPT_RETURNTRANSFER is used.
     * @var boolean
     */
    public $binarytransfer;

    /**
     * TRUE to reset the HTTP request method to GET. Since GET is the default,
     * this is only necessary if the request method has been changed.
     * @var boolean
     */
    public $httpget;

    /**
     * TRUE to output verbose information. Writes output to STDERR, or
     * the file specified using CURLOPT_STDERR.
     * @var boolean
     */
    public $verbose = false;

    /**
     * FALSE to stop cURL from verifying the peer's certificate. Alternate
     * certificates to verify against can be specified with the CURLOPT_CAINFO
     * option or a certificate directory can be specified with the CURLOPT_CAPATH
     * option.
     * @var boolean
     */
    public $ssl_verifypeer = false;

    /**
     * 1 to check the existence of a common name in the SSL peer
     * certificate. 2 to check the existence of a common name and
     * also verify that it matches the hostname provided. In
     * production environments the value of this option should be
     * kept at 2 (default value).
     * @var int
     */
    public $ssl_verifyhost;

    /**
     * The HTTP authentication method(s) to use. The options are:
     * CURLAUTH_BASIC, CURLAUTH_DIGEST, CURLAUTH_GSSNEGOTIATE,
     * CURLAUTH_NTLM, CURLAUTH_ANY, and CURLAUTH_ANYSAFE.
     *
     * The bitwise | (or) operator can be used to combine more than one
     * method. If this is done, cURL will poll the server to see what
     * methods it supports and pick the best one.
     *
     * CURLAUTH_ANY is an alias for CURLAUTH_BASIC | CURLAUTH_DIGEST |
     * CURLAUTH_GSSNEGOTIATE | CURLAUTH_NTLM.
     *
     * CURLAUTH_ANYSAFE is an alias for CURLAUTH_DIGEST |
     * CURLAUTH_GSSNEGOTIATE | CURLAUTH_NTLM.
     * @var int
     */
    public $httpauth;

    /**
     * CURL_HTTP_VERSION_NONE (default, lets CURL decide which version
     * to use), CURL_HTTP_VERSION_1_0 (forces HTTP/1.0), or CURL_HTTP_VERSION_1_1
     * (forces HTTP/1.1).
     * @var int
     */
    public $http_version;

    /**
     * An alternative port number to connect to.
     * @var int
     */
    public $port;

    /**
     * The number of seconds to wait while trying to connect.
     * Use 0 to wait indefinitely.
     * @var int
     */
    public $connecttimeout;

    /**
     * The number of milliseconds to wait while trying to connect.
     * Use 0 to wait indefinitely. If libcurl is built to use the
     * standard system name resolver, that portion of the connect
     * will still use full-second resolution for timeouts with a
     * minimum timeout allowed of one second.
     * @var int
     */
    public $connecttimeout_ms;

    /**
     * The maximum number of seconds to allow cURL functions
     * to execute.
     * @var int
     */
    public $timeout;

    /**
     * The maximum number of milliseconds to allow cURL functions
     * to execute. If libcurl is built to use the standard system
     * name resolver, that portion of the connect will still use
     * full-second resolution for timeouts with a minimum timeout
     * allowed of one second.
     * @var int
     */
    public $timeout_ms;

    /**
     * The contents of the "Cookie: " header to be used in
     * the HTTP request. Note that multiple cookies are
     * separated with a semicolon followed by a space
     * (e.g., "fruit=apple; colour=red")
     * @var string
     */
    public $cookie;

    /**
     * The name of the file containing the cookie data. The cookie
     * file can be in Netscape format, or just plain HTTP-style
     * headers dumped into a file. If the name is an empty string,
     * no cookies are loaded, but cookie handling is still enabled.
     * @var string
     */
    public $cookiefile;

    /**
     * The name of a file to save all internal cookies to when the handle
     * is closed, e.g. after a call to curl_close.
     * @var string
     */
    public $cookiejar;

    /**
     * A directory that holds multiple CA certificates.
     * Use this option alongside CURLOPT_SSL_VERIFYPEER.
     * @var string
     */
    public $capath;

    /**
     * The name of a file holding one or more certificates
     * to verify the peer with. This only makes sense when
     * used in combination with CURLOPT_SSL_VERIFYPEER.
     * @var string
     */
    public $cainfo;

    /**
     * The contents of the "Accept-Encoding: " header. This
     * enables decoding of the response. Supported encodings
     * are "identity", "deflate", and "gzip". If an empty
     * string, "", is set, a header containing all supported
     * encoding types is sent.
     * @var string
     */
    public $encoding;

    /**
     * The password required to use the CURLOPT_SSLKEY
     * or CURLOPT_SSH_PRIVATE_KEYFILE private key.
     * @var string
     */
    public $keypasswd;

    /**
     * A string containing 32 hexadecimal digits. The
     * string should be the MD5 checksum of the remote
     * host's public key, and libcurl will reject the
     * connection to the host unless the md5sums match.
     * This option is only for SCP and SFTP transfers.
     * @var string
     */
    public $ssh_host_public_key_md5;

    /**
     * The file name for your public key. If not used, libcurl
     * defaults to $HOME/.ssh/id_dsa.pub if the HOME environment
     * variable is set, and just "id_dsa.pub" in the current
     * directory if HOME is not set.
     * @var string
     */
    public $ssh_public_keyfile;

    /**
     * The file name for your private key. If not used, libcurl
     * defaults to $HOME/.ssh/id_dsa if the HOME environment
     * variable is set, and just "id_dsa" in the current directory
     * if HOME is not set. If the file is password-protected,
     * set the password with CURLOPT_KEYPASSWD.
     * @var string
     */
    public $ssh_private_keyfile;

    /**
     * A list of ciphers to use for SSL. For example, RC4-SHA
     * and TLSv1 are valid cipher lists.
     * @var string
     */
    public $ssl_cipher_list;

    /**
     * The name of a file containing a PEM formatted certificate
     * @var string
     */
    public $sslcert;

    /**
     * The password required to use the CURLOPT_SSLCERT certificate.
     * @var string
     */
    public $sslcertpasswd;

    /**
     * The format of the certificate. Supported formats are
     * "PEM" (default), "DER", and "ENG"
     * @var string
     */
    public $sslcerttype;

    /**
     * The identifier for the crypto engine of the private SSL
     * key specified in CURLOPT_SSLKEY.
     * @var string
     */
    public $sslengine;

    /**
     * The identifier for the crypto engine used for
     * asymmetric crypto operations.
     * @var string
     */
    public $sslengine_default;

    /**
     * The name of a file containing a private SSL key.
     * @var string
     */
    public $sslkey;

    /**
     * The secret password needed to use the private
     * SSL key specified in CURLOPT_SSLKEY.
     * @var string
     */
    public $sslkeypasswd;

    /**
     * The identifier for the CURLOPT_SSLVERSION
     * property.
     * @var integer
     */
    public $sslversion;

    /**
     * The key type of the private SSL key specified in
     * CURLOPT_SSLKEY. Supported key types are "PEM"
     * (default), "DER", and "ENG".
     * @var string
     */
    public $sslkeytype;

    /**
     * The KRB4 (Kerberos 4) security level. Any of the following
     * values (in order from least to most powerful) are valid:
     * "clear", "safe", "confidential", "private".. If the string
     * does not match one of these, "private" is used. Setting this
     * option to NULL will disable KRB4 security. Currently KRB4
     * security only works with FTP transactions.
     * @var string
     */
    public $krb4level;

    /**
     * The HTTP proxy to tunnel requests through.
     * @var string
     */
    public $proxy;

    /**
     * A username and password formatted as "[username]:[password]"
     * to use for the connection to the proxy.
     * @var string
     */
    public $proxyuserpwd;

    /**
     * The contents of the "Referer: " header to be used
     * in a HTTP request.
     * @var string
     */
    public $referer;

    /**
     * The contents of the "User-Agent: " header to be used
     * in a HTTP request.
     * @var string
     */
    public $useragent;

    /**
     * The URL to fetch.
     * @var string
     */
    public $url;

    /**
     * User and password in
     * format user=pass
     * @var string
     */
    public $userpwd;

    /**
     * Main headers
     * @var \OtherCode\Rest\Payloads\Headers
     */
    public $httpheader;

    /**
     * Array of 200 codes that will be
     * considered as success
     * @var array
     */
    public $http200aliases;

    /**
     * Array of ftp commands o perform
     * before the request
     * @var array
     */
    public $postquote;

    /**
     * Array of ftp commands o perform
     * after the request
     * @var array
     */
    public $quote;

    /**
     * File path for log errors
     * @var string
     */
    public $stderr;

}