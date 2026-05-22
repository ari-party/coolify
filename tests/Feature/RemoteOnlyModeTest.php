<?php

/**
 * Unit tests for the COOLIFY_REMOTE_ONLY flag and isRemoteOnly() helper.
 *
 * Remote-only mode allows Coolify to run in environments without access to
 * a host Docker socket (e.g. Railway, Fly.io). The flag prevents seeding
 * of the localhost server (id=0) and its associated SSH key + StandaloneDocker.
 */
it('isRemoteOnly returns false by default', function () {
    config()->set('constants.coolify.remote_only', false);

    expect(isRemoteOnly())->toBeFalse();
});

it('isRemoteOnly returns true when the config flag is set', function () {
    config()->set('constants.coolify.remote_only', true);

    expect(isRemoteOnly())->toBeTrue();
});

it('isRemoteOnly casts truthy values to bool', function () {
    config()->set('constants.coolify.remote_only', 1);
    expect(isRemoteOnly())->toBeTrue();

    config()->set('constants.coolify.remote_only', '1');
    expect(isRemoteOnly())->toBeTrue();

    config()->set('constants.coolify.remote_only', 0);
    expect(isRemoteOnly())->toBeFalse();

    config()->set('constants.coolify.remote_only', '');
    expect(isRemoteOnly())->toBeFalse();
});

it('exposes constants.coolify.remote_only from the COOLIFY_REMOTE_ONLY env var', function () {
    expect(config('constants.coolify'))->toHaveKey('remote_only');
});
