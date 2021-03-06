# HBM Async Worker Bundle

## Team

### Developers
Christian Puchinger - christian.puchinger@burda.com

## Installation

### Step 1: Download the Bundle

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```bash
$ composer require burdadirect/symfony-bundle-async-worker
```

This command requires you to have Composer installed globally, as explained
in the [installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

### Step 2: Enable the Bundle

With Symfony 4 the bundle is enabled automatically for all environments (see `config/bundles.php`). 


### Step 3: Configuration

```yml
hbm_async_worker:
    runner:
        ids:
          - ernie
          - bert
          - tiffy
        runtime: 3600
        fuzz: 600
        timeout: 2.0
        block: 10
    queue:
        prefix: queue.
        priorities:
            - low
            - medium
            - high
    error:
        log: true
        file: /var/log/php-async-worker.log
    mail:
        defaultTo: 
        fromName: 'HBM Async Worker'
        fromMail: 'async@example.com'
    output:
        formats:
            debug:     { foreground: null,    background: null, options: [] }
            info:      { foreground: blue,    background: null, options: [] }
            notice:    { foreground: cyan,    background: null, options: [] }
            warning:   { foreground: magenta, background: null, options: [] }
            error:     { foreground: red,     background: null, options: [] }
            critical:  { foreground: red,     background: null, options: [] }
            alert:     { foreground: red,     background: null, options: [bold] }
            emergency: { foreground: red,     background: null, options: [bold] }
```
