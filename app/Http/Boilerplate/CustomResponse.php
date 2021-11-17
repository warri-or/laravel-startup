<?php


namespace App\Http\Boilerplate;


use Symfony\Component\HttpFoundation\Response;

class CustomResponse extends Response {

    protected $header = [
        'Content-Type' => 'application/json'
    ];

    protected $response = [
        'success' => false,
        'message' => 'Something went wrong',
        'data' => []
    ];

    public function __construct($type, $content = '', int $status = 200) {
        parent::__construct($content, $status, $this->header);
        $this->response['success'] = $type;
    }

    public function getMessage(): string {
        return $this->response['message']; //json_encode($this->getContent())->message;
    }

    public function setMessage(string $message) {
        $this->response['message'] = $message;
    }

    public function getData() {
        return $this->response['data']; //json_encode($this->getContent())->data;
    }

    public function setData(array $data) {
        $this->response['data'] = $data;
    }

    public function getStatus(): bool {
        return $this->response['success']; //json_encode($this->getContent())->success;
    }

    /**
     * Add multiple cookies to the response.
     *
     * @param string $message
     *
     * @return CustomResponse
     */
    public function message(string $message) {
        $this->setMessage($message);
        $this->setContent(json_encode($this->response));
        return $this;
    }

    /**
     * Add multiple cookies to the response.
     *
     * @return CustomResponse
     */
    public function default() {
        $this->setContent(json_encode($this->response));
        return $this;
    }

    /**
     * Add multiple cookies to the response.
     *
     * @param mixed $data
     *
     * @return CustomResponse
     */
    public function data($data) {
        $this->setData($data);
        $this->setContent(json_encode($this->response));
        return $this;
    }
}
