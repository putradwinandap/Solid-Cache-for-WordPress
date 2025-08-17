<?php

namespace PtrSoc\Domain\Contracts;

/**
 * Contract to handle AJAX requests.
 *
 * This interface defines standart methods that must be implemented
 * by each AJAX handler, including action name, nonce, capability
 * and execution callback.
 */
interface AjaxHandler
{
    /**
     * Get the action name.
     *
     * This name is used to register with the WordPress Hook
     *  - wp_ajax_{action}
     *  - wp_ajax_nopriv_{action} (if public)
     *
     * @return string Action name
     */
    public function action(): string;

    /**
     * Get the action name for the nonce.
     *
     * Usually the same or a derivative of the main action,
     * used in check_ajax_referer().
     *
     * @return string Nonce action name
     */
    public function nonceAction(): string;

    /**
     * Get the capability required to execute the AJAX action.
     *
     * If null, the action is accessible to all users.
     *
     * @return string|null Capability name
     */
    public function capability(): ?string;

    /**
     * The main callback that will be called when AJAX is executed.
     *
     * @return mixed Callback execution result (usually echo/JSON response).
     */
    public function callback();
}
