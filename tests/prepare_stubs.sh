#!/usr/bin/env bash

TWILL_VERSION="$1"

rm -f Stubs

if [ "$TWILL_VERSION" == '2.*' ]; then
    ln -s __stubs__/2.x Stubs
else
    ln -s __stubs__/3.x Stubs
fi
