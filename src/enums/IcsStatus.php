<?php

namespace boundstate\eventful\enums;

/**
 * Statuses for iCalendar (VEVENT) calendar components.
 *
 * @see https://datatracker.ietf.org/doc/html/rfc5545#section-3.8.1.11
 */
enum IcsStatus: string
{
    case TENTATIVE = 'TENTATIVE';
    case CONFIRMED = 'CONFIRMED';
    case CANCELLED = 'CANCELLED';
}
