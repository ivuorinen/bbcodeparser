# Contributing

Contributions are **welcome** and will be fully **credited**.

We accept contributions via Pull Requests on [GitHub][repo].

## Pull Requests

- **[PSR-2 Coding Standard][psr2]** - The easiest way to apply the conventions
  is to install [PHP Code Sniffer][phpcs].

- **Add tests!** - Your patch won't be accepted if it doesn't have tests.

- **Document any change in behaviour** - Make sure the `README.md`
  and any other relevant documentation are kept up-to-date.

- **Consider our release cycle** - We try to follow [SemVer v2][semver].
  Randomly breaking public APIs is not an option.

- **Create feature branches** - Don't ask us to pull from your main branch.

- **One pull request per feature** - If you want to do more than one
  thing, send multiple pull requests.

- **Send coherent history** - Make sure each individual commit in your pull
  request is meaningful. If you had to make multiple intermediate commits
  while developing, please [squash them][git-squash] before submitting.

## Running Tests

```bash
composer test
```

**Happy coding**!

[repo]: https://github.com/ivuorinen/bbcodeparser
[semver]: https://semver.org
[psr2]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md
[phpcs]: https://github.com/squizlabs/PHP_CodeSniffer
[git-squash]: https://www.git-scm.com/book/en/v2/Git-Tools-Rewriting-History#Changing-Multiple-Commit-Messages
