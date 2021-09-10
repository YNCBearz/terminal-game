#/bin/bash

# Colors
red=`tput setaf 1`
green=`tput setaf 2`
yellow=`tput setaf 3`
original=`tput sgr0`

# Copy .env.example to .env
echo "${yellow}[Initializing project...] generating .env${original}"
cp .env.example .env
echo "${yellow}[Initializing project...] generating .env success${original}"

# composer install
echo "${yellow}[Initializing project...] composer install${original}"
composer install
echo "${yellow}[Initializing project...] composer install success${original}"