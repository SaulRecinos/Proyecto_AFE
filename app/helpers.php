<?php

if (! function_exists('format_usd')) {
  /**
   * Formatea un monto en dólares estadounidenses (USD).
   */
  function format_usd(float|int|string|null $amount): string
  {
    return '$'.number_format((float) ($amount ?? 0), 2);
  }
}
