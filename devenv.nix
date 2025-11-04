{ pkgs, lib, config, inputs, ... }:

{
  cachix.pull = [ "codetetic-php" ];

  # https://devenv.sh/basics/

  # https://devenv.sh/packages/
  packages = [ ];

  # https://devenv.sh/languages/
  languages.php = {
    enable = true;
    version = "8.2";
  };

  # https://devenv.sh/processes/
  # processes.dev.exec = "${lib.getExe pkgs.watchexec} -n -- ls -la";

  # https://devenv.sh/services/
  # services.postgres.enable = true;

  # https://devenv.sh/scripts/

  # https://devenv.sh/basics/
  enterShell = ''
  '';

  # https://devenv.sh/tasks/
  tasks = {
    "app:setup" = {
      exec = ''
        composer install
      '';
      execIfModified = [
        "composer.json"
        "composer.lock"
      ];
    };
    "devenv:enterShell".after = [ "app:setup" ];
  };

  # https://devenv.sh/tests/
  enterTest = ''
    ./vendor/bin/pest --parallel
  '';

  # https://devenv.sh/git-hooks/
  # git-hooks.hooks.shellcheck.enable = true;

  # See full reference at https://devenv.sh/reference/options/
}
