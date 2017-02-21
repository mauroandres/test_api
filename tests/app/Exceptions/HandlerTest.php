<?php
namespace Tests\App\Exceptions;

use TestCase;
use \Mockery;
use App\Exceptions\Handler;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class HandlerTest extends TestCase
{
    /** @test */
    public function jsonResultsForexceptions()
    {
        $subject = Mockery::mock(Handler::class)->makePartial();

        $request = Mockery::mock(Request::class);
        
        $exceptions = [
            [
                'mock' => NotFoundHttpException::class,
                'status' => 404,
                'message' => 'Not Found'
            ],
            [
                'mock' => AccessDeniedHttpException::class,
                'status' => 403,
                'message' => 'Forbidden'
            ],
            [
                'mock' => ModelNotFoundException::class,
                'status' => 404,
                'message' => 'Not Found'
            ]
        ];
    
        foreach ($exceptions as $e) {
            $exception = Mockery::mock($e['mock']);
            $exception->shouldReceive('getMessage')->andReturn($e['message']);
            $exception->shouldReceive('getStatusCode')->andReturn($e['status']);

            /** @var JsonResponse $result */
            $result = $subject->render($request, $exception);
            $data = $result->getData();

            $this->assertEquals($e['status'], $result->getStatusCode());
            $this->assertEquals($e['message'], $data->error->message);
            $this->assertEquals($e['status'], $data->error->status);
        }
    }
}