#/bin/bash

# Colors
red=`tput setaf 1`
green=`tput setaf 2`
original=`tput sgr0`

# Copy .env.example to .env
echo "${green}[Initializing project...] generating .env${original}"
cp .env.example .env
echo "${green}[Initializing project...] generating .env success${original}"

# composer install
echo "${green}[Initializing project...] composer install${original}"
composer install
echo "${green}[Initializing project...] composer install success${original}"