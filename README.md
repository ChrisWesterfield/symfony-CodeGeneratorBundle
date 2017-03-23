# MJR.ONE Code Generator Bundle

This Bundle contains an Code Generator to rapidly Develope using Symfony Framework.

## Installation

Step 1: Download the Bundle
---------------------------

Open a command console, enter your project directory and execute the following command to download the latest stable version of this bundle:

.. code-block:: bash

    $ composer require mjr/code-generator-bundle "1.*"

This command requires you to have Composer installed globally, as explained in the `installation chapter <https://getcomposer.org/doc/00-intro.md>`_ of the Composer documentation.

Step 2: Enable the Bundle
-------------------------

Then, enable the bundle by adding the following line in the ``app/AppKernel.php`` file of your project:

.. code-block:: php

    <?php
    // app/AppKernel.php
    use MjrOne\CodeGeneratorBundle\MjrOneCodeGeneratorBundle;

    // ...
    class AppKernel extends Kernel
    {
        public function registerBundles()
        {
            $bundles = array(
                // ...
                new MjrOneCodeGeneratorBundle(),
            );

            // ...
        }
    }

Step 3: Update Configuration
-------------------------

You might need to update/modify the Configuration of the Bundle. It is optimized twords Symfony. If you have a different Layout, okease check the Bundle Configuration file!

## Supported Code Generators

### Service
This Code Generator helps to create Simple Services with Automated Dependency Injection (both __constructor based as well as setter based).
Support has been added for Controller Services (All Required options are set)
All added Functions are put inside of a TraitServiceXX trait and added to Service Class.
In case of an Controller, a Route Annotation is also added
**This is fully configurable over an annotation.**

### Mutator
Adds Getters & Setters as well as Methods to check if contains either a Value at all or checks on Array Value(array + array collection) [has].
For Array Collections and arrays the methods addXX, removeXX, countXX are also added.
**This is fully configurable over an annotation.**

### Entity

One Time Code Generation.
Adds Repository Class if not exists
**This is fully configurable over an annotation.**


### Repository
adds some base functions to your repository.
**This is fully configurable over an annotation.**

## Commands

### Generate Code
./bin/console mjr:generateCode --help                                                                                                                                                                                                                         ✓  206  00:28:28
Usage:
  mjr:generateCode [options] [--] <file>

Arguments:
  file                  File to Generator Code For

Options:
  -a, --all             Update all Files in Bundle,
  -h, --help            Display this help message
  -q, --quiet           Do not output any message
  -V, --version         Display this application version
      --ansi            Force ANSI output
      --no-ansi         Disable ANSI output
  -n, --no-interaction  Do not ask any interactive question
  -e, --env=ENV         The environment name [default: "spectware_dev"]
      --no-debug        Switches off debug mode
  -v|vv|vvv, --verbose  Increase the verbosity of messages: 1 for normal output, 2 for more verbose output and 3 for debug

Help:
Generate MJRONE Bundle Codes

This is the Main Code Generator.
If you add the flag -a or --all file needs to be the path to a bundle!

### Update Routing Files
./bin/console mjr:generateRouting --help                                                                                                                                                                                                                      ✓  208  00:34:16
Usage:
  mjr:generateRouting [<cleanup>]

Arguments:
  cleanup               remove Not Found Options

Options:
  -h, --help            Display this help message
  -q, --quiet           Do not output any message
  -V, --version         Display this application version
      --ansi            Force ANSI output
      --no-ansi         Disable ANSI output
  -n, --no-interaction  Do not ask any interactive question
  -e, --env=ENV         The environment name [default: "spectware_dev"]
      --no-debug        Switches off debug mode
  -v|vv|vvv, --verbose  Increase the verbosity of messages: 1 for normal output, 2 for more verbose output and 3 for debug

Help:
  Generates a bundle Routing

if the argument cleanup is added, the generator starts with an empty configuration file!


### Bundle Generator

### Controller Generator

### Entity Generator
