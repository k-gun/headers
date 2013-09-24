<?php
/**
 * Copyright 2013, Kerem Gunes <http://qeremy.com/>.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may
 * not use this file except in compliance with the License. You may obtain
 * a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations
 * under the License.
 */

/**
 * @class Headers v0.1
 *
 * Headers object.
 */
class Headers
{
    // Storage var
    protected $_headers = array();

    /**
     * Create Headers object
     *
     * @param array $headers
     */
    public function __construct(Array $headers = null) {
        if (!empty($headers)) {
            $this->set($headers);
        }
    }

    /**
     * Shortcut for set/get
     *
     * @param  string $call
     * @param  array  $args
     * @return mixed
     */
    public function __call($call, $args) {
        $cmd = substr($call, 0, 3);
        $key = substr($call, 3);

        if ($cmd == 'set') {
            $this->set($key, $args[0]);
            return $this;
        }

        if ($cmd == 'get') {
            return $this->get($key);
        }
    }

    /**
     * Set header name & value
     *
     * @param string $key
     * @param string $val
     */
    public function set($key, $val = null) {
        if (is_array($key)) {
            foreach ($key as $k => $v) {
                $this->set($k, $v);
            }
        } else {
            $key = $this->_prepareKey($key, true);
            $this->_headers[$key] = $val;
        }
        return $this;
    }

    /**
     * Get header value
     *
     * @param  string $key
     * @return string
     */
    public function get($key) {
        $key = $this->_prepareKey($key);
        if (isset($this->_headers[$key])) {
            return $this->_headers[$key];
        }
    }

    /**
     * Send headers
     *
     * @throw HeadersException
     */
    public function send() {
        if (headers_sent()) {
            throw new HeadersException(
                'Headers already sent! Tip: try ob_start() before calling send()]');
        }

        if (!empty($this->_headers)) {
            foreach ($this->_headers as $key => $val) {
                header("$key: $val");
            }
        }
    }

    /**
     * Remove header
     * Note: The removed header will not be sent
     *
     * @param string $key
     * @return object $this
     */
    public function remove($key) {
        $key = $this->_prepareKey($key);
        unset($this->_headers[$key]);
        header_remove($key);

        return $this;
    }

    /**
     * Remove all headers
     */
    public function removeAll() {
        if (!empty($this->_headers)) {
            foreach ($this->_headers as $key => $val) {
                $this->remove($key);
            }
        }
    }

    /**
     * Prepare header key
     *
     * @param  string  $key
     * @param  boolean $dasherize
     * @return string
     */
    protected function _prepareKey($key, $dasherize = false) {
        if ($dasherize) {
            $key = preg_replace_callback('~(?:[A-Z])~', function($m) {
                return '-'. $m[0];
            }, $key);
            $key = trim($key, '-');
        }

        return strtolower($key);
    }
}
