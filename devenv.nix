{
  pkgs,
  lib,
  ...
}:

{
  cachix.enable = lib.mkDefault false;

  languages.php = {
    enable = true;
    package = pkgs.php82.buildEnv {
      extensions = { all, enabled }: enabled ++ [ all.xdebug ];
      extraConfig = ''
        memory_limit=-1
      '';
    };
  };

  enterShell = '''';

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

  enterTest = ''
    export XDEBUG_MODE=coverage
    ./vendor/bin/pest --parallel --coverage --coverage-html=build/coverage
  '';

  git-hooks.hooks = {
    trim-trailing-whitespace = {
      enable = true;
    };

    pint = {
      enable = true;
      name = "Pint Code Style Fixer";
      entry = "./vendor/bin/pint --test";
      types = [ "php" ];
    };
  };
}
