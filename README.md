# Dzoganik_ErpCli Module

Module for CLI commands for the Dzoganik_Erp module.

## Commands

- bin/magento dzoganik:erp:show-transmissions

```
Description:
Show ERP transmission attempts.

Usage:
dzoganik:erp:show-transmissions <list-type>

Arguments:
list-type

Options:
-h, --help              Display this help message
-q, --quiet             Do not output any message
-V, --version           Display this application version
--ansi              Force ANSI output
--no-ansi           Disable ANSI output
-n, --no-interaction    Do not ask any interactive question
--disable-tracking  Disable tracking of execution to cron_schedule table.
-v|vv|vvv, --verbose    Increase the verbosity of messages: 1 for normal output, 2 for more verbose output and 3 for debug
```

### Available list types
- successful
- failed

### Output example:
```
bin/magento dzoganik:erp:show-transmissions successful
+-----------------+----------+-------------+---------------------+
| transmission_id | order_id | return_code | created_at          |
+-----------------+----------+-------------+---------------------+
| 5               | 680271   | 200         | 2022-06-14 13:55:18 |
| 6               | 680272   | 200         | 2022-06-14 13:55:28 |
+-----------------+----------+-------------+---------------------+
```
