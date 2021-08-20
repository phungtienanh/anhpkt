<?php
 namespace MailPoetVendor; if (!defined('ABSPATH')) exit; class Swift_Transport_StreamBuffer extends \MailPoetVendor\Swift_ByteStream_AbstractFilterableInputStream implements \MailPoetVendor\Swift_Transport_IoBuffer { private $stream; private $in; private $out; private $params = []; private $replacementFactory; private $translations = []; public function __construct(\MailPoetVendor\Swift_ReplacementFilterFactory $replacementFactory) { $this->replacementFactory = $replacementFactory; } public function initialize(array $params) { $this->params = $params; switch ($params['type']) { case self::TYPE_PROCESS: $this->establishProcessConnection(); break; case self::TYPE_SOCKET: default: $this->establishSocketConnection(); break; } } public function setParam($param, $value) { if (isset($this->stream)) { switch ($param) { case 'timeout': if ($this->stream) { \stream_set_timeout($this->stream, $value); } break; case 'blocking': if ($this->stream) { \stream_set_blocking($this->stream, 1); } } } $this->params[$param] = $value; } public function startTLS() { return \stream_socket_enable_crypto($this->stream, \true, \STREAM_CRYPTO_METHOD_TLSv1_0_CLIENT | \STREAM_CRYPTO_METHOD_TLSv1_1_CLIENT | \STREAM_CRYPTO_METHOD_TLSv1_2_CLIENT); } public function terminate() { if (isset($this->stream)) { switch ($this->params['type']) { case self::TYPE_PROCESS: \fclose($this->in); \fclose($this->out); \proc_close($this->stream); break; case self::TYPE_SOCKET: default: \fclose($this->stream); break; } } $this->stream = null; $this->out = null; $this->in = null; } public function setWriteTranslations(array $replacements) { foreach ($this->translations as $search => $replace) { if (!isset($replacements[$search])) { $this->removeFilter($search); unset($this->translations[$search]); } } foreach ($replacements as $search => $replace) { if (!isset($this->translations[$search])) { $this->addFilter($this->replacementFactory->createFilter($search, $replace), $search); $this->translations[$search] = \true; } } } public function readLine($sequence) { if (isset($this->out) && !\feof($this->out)) { $line = \fgets($this->out); if (0 == \strlen($line)) { $metas = \stream_get_meta_data($this->out); if ($metas['timed_out']) { throw new \MailPoetVendor\Swift_IoException('Connection to ' . $this->getReadConnectionDescription() . ' Timed Out'); } } return $line; } } public function read($length) { if (isset($this->out) && !\feof($this->out)) { $ret = \fread($this->out, $length); if (0 == \strlen($ret)) { $metas = \stream_get_meta_data($this->out); if ($metas['timed_out']) { throw new \MailPoetVendor\Swift_IoException('Connection to ' . $this->getReadConnectionDescription() . ' Timed Out'); } } return $ret; } } public function setReadPointer($byteOffset) { } protected function flush() { if (isset($this->in)) { \fflush($this->in); } } protected function doCommit($bytes) { if (isset($this->in)) { $bytesToWrite = \strlen($bytes); $totalBytesWritten = 0; while ($totalBytesWritten < $bytesToWrite) { $bytesWritten = \fwrite($this->in, \substr($bytes, $totalBytesWritten)); if (\false === $bytesWritten || 0 === $bytesWritten) { break; } $totalBytesWritten += $bytesWritten; } if ($totalBytesWritten > 0) { return ++$this->sequence; } } } private function establishSocketConnection() { $host = $this->params['host']; if (!empty($this->params['protocol'])) { $host = $this->params['protocol'] . '://' . $host; } $timeout = 15; if (!empty($this->params['timeout'])) { $timeout = $this->params['timeout']; } $options = []; if (!empty($this->params['sourceIp'])) { $options['socket']['bindto'] = $this->params['sourceIp'] . ':0'; } if (isset($this->params['stream_context_options'])) { $options = \array_merge($options, $this->params['stream_context_options']); } $streamContext = \stream_context_create($options); \set_error_handler(function ($type, $msg) { throw new \MailPoetVendor\Swift_TransportException('Connection could not be established with host ' . $this->params['host'] . ' :' . $msg); }); try { $this->stream = \stream_socket_client($host . ':' . $this->params['port'], $errno, $errstr, $timeout, \STREAM_CLIENT_CONNECT, $streamContext); } finally { \restore_error_handler(); } if (!empty($this->params['blocking'])) { \stream_set_blocking($this->stream, 1); } else { \stream_set_blocking($this->stream, 0); } \stream_set_timeout($this->stream, $timeout); $this->in =& $this->stream; $this->out =& $this->stream; } private function establishProcessConnection() { $command = $this->params['command']; $descriptorSpec = [0 => ['pipe', 'r'], 1 => ['pipe', 'w'], 2 => ['pipe', 'w']]; $pipes = []; $this->stream = \proc_open($command, $descriptorSpec, $pipes); \stream_set_blocking($pipes[2], 0); if ($err = \stream_get_contents($pipes[2])) { throw new \MailPoetVendor\Swift_TransportException('Process could not be started [' . $err . ']'); } $this->in =& $pipes[0]; $this->out =& $pipes[1]; } private function getReadConnectionDescription() { switch ($this->params['type']) { case self::TYPE_PROCESS: return 'Process ' . $this->params['command']; break; case self::TYPE_SOCKET: default: $host = $this->params['host']; if (!empty($this->params['protocol'])) { $host = $this->params['protocol'] . '://' . $host; } $host .= ':' . $this->params['port']; return $host; break; } } } 