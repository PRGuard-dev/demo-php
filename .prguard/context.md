# Context file — PRGuard demo (PHP)

## About this service

A tiny order-lookup API: `src/OrderService.php` holds the business
logic, `src/Db.php` holds the sanctioned data helpers (parameter-bound
SQL and money formatting).

## Standards

- **Secrets.** Credentials are never committed. A key that reaches a
  commit is *compromised*: it must be rotated with the provider, not
  merely moved to an environment variable.
- **Money.** Amounts are stored as an integer number of cents and are
  formatted only through the shared `Db::money()` helper — see
  @ref:src/Db.php. Never build a currency string by hand: dividing cents
  by 100 produces a float, which loses precision and drops trailing
  zeros.
  Treat violations of this rule as WARNING severity — a correctness
  risk to fix, not a blocking security error.
- Methods stay small and single-purpose.

## Out of scope

- Performance tuning
- Test coverage
