<?php
/**
 * Created by PhpStorm.
 * User: lilipeng
 * Date: 12/5/17
 * Time: 23:46
 */

namespace Restaurant\Http;


class Methods
{
    /*
     * GET should return the requested resource(s)
     */
    const GET = "GET";
    /*
     * POST should create a resource
     */
    const POST = "POST";

    /*
     * PUT should update a resource
     */
    const PUT = "PUT";
    /*
     * Delete should remove the requested resource
     */
    const DELETE = "DELETE";
    /*
     * Options should respond with acceptable methods for the requested resource
     */
    const OPTIONS = "OPTIONS";
    /**
     * Patch is an update request
     */
    const PATCH = "PATCH";
    /**
     * Head status is identical to get, except that the message body is not returned.
     */
    const HEAD = "HEAD";
}