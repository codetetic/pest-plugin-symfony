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
  git-hooks.pre-commit.text = ''
    echo "Running Laravel Pint..."
    ./vendor/bin/pint --test
    if [ $? -eq 0 ]; then
      echo "Code style is clean!"
      exit 0
    else
      echo "Code style issues found. Running Pint to fix..."
      ./vendor/bin/pint
      echo "Code style issues fixed. Please review and stage the changes."
      exit 1
    fi
  '';

  # See full reference at https://devenv.sh/reference/options/
}
