# MJR.ONE Code Generator Bundle

This Bundle contains an Code Generator to rapidly Develope using Symfony Framework.

## Installation

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


## Examples

## Unit Tests