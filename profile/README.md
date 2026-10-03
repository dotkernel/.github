![](https://github.com/dotkernel/dotkernel.github.io/blob/main/img/dk_logo_2024.svg) 


## A headless platform for building modern web applications — for humans and AI agents

Dotkernel is a set of open-source PHP applications - REST API, admin, and queue - that ship assembled on Mezzio and Laminas, over one shared Doctrine domain layer called Core. OAuth2, RBAC, HAL, and a generated OpenAPI spec are wired together on install, not left for you to choose.

- built on top of Mezzio microframework using Laminas components
- with both [backend management](https://github.com/dotkernel/admin) and [frontend-agnostic capabilities](https://github.com/dotkernel/api)
- built entirely on PSR-15 middleware
- follows the middleware pipeline pattern offered by Laminas and the PSR standards
- adhering strictly to [**PSR-3**](https://www.php-fig.org/psr/psr-3/) ([logging](https://github.com/php-fig/log)), [**PSR-7**](https://www.php-fig.org/psr/psr-7/) ([HTTP messages](https://github.com/php-fig/http-message)), [**PSR-11**](https://www.php-fig.org/psr/psr-11/) ([containers](https://github.com/php-fig/container)), [**PSR-15**](https://www.php-fig.org/psr/psr-15/) ([middleware](https://github.com/php-fig/http-server-handler))

### Building Dotkernel applications with AI: dotboost

[**dotboost**](https://github.com/dotkernel/dotboost) is drop-in Claude Code configuration for any Dotkernel application - API, Admin, Frontend, Light, Queue, or a project derived from one of them. The payload is a `.claude/` directory you copy into your project root; every skill detects the variant first and applies the matching dialect, so the assistant follows this platform's conventions instead of generic PHP habits.

What it brings to a session:

- **`/dk-*` commands** for the work that recurs - bootstrapping a fresh clone, planning a module, wiring a route end to end, tracing a request through the pipeline, running the QA gate, and a pre-PR convention review.
- **Skills covering the platform** - module structure and Core layering, handler naming, Doctrine entities and migrations, input filters, HAL responses, OpenAPI attributes, the evolution pattern, testing, and the PSR standards as they are actually applied here.
- **A dependency ladder instead of guesswork** - installed packages, then `dotkernel/*`, then Laminas and Mezzio, then vetted community packages, and only then hand-rolled code. Package names are verified against `composer.lock` or Packagist, never recalled from memory.
- **Guardrails that hold** - `*.local.php` and `data/oauth/` are unreadable, so database credentials and OAuth signing keys never reach the transcript. Dependency manifests, `vendor/`, and migrations cannot be written; installs, destructive git, and DB-mutating commands are blocked, including inside compound commands.

### Being consumed by AI

A headless platform has no UI to explain itself, so the contract has to be machine-readable. That is the same property agents need, and we treat it as a first-class concern rather than an add-on:

- **A generated OpenAPI spec on every install** - your endpoints, schemas, and auth flows are described in a format LLM-based tooling and agent frameworks read directly, with no hand-written docs to drift out of date.
- **Predictable, standards-based responses** - HAL representations and PSR-7 messages mean an agent can traverse an API it has never seen before from the payload alone.
- **Agent-readable documentation** - our content is published as markdown alongside the HTML, with an [`llms.txt`](https://llmstxt.org) index, so assistants and crawlers ingest the source text instead of scraping a rendered page.

### Documentation

Documentation is available at: https://docs.dotkernel.org

### Discussion

Open discussions are available at: https://github.com/orgs/dotkernel/discussions

### Latest blog posts

<!--- blog_start --->
 - [How to Use Twig Markdown to Generate HTML Pages at Runtime](https://www.dotkernel.com/how-to/how-to-use-twig-markdown-to-generate-html-pages-at-runtime/)
 - [What "Production Ready" Means for Dotkernel API](https://www.dotkernel.com/dotkernel-api/what-production-ready-means-for-dotkernel-api/)
 - [How to build this website starting from Dotkernel Light](https://www.dotkernel.com/dotkernel/how-to-build-this-website-starting-from-dotkernel-light/)
 - [Request Lifecycle for a Mezzio-Based Application](https://www.dotkernel.com/architecture/request-lifecycle-for-a-mezzio-based-application/)
 - [Implementing Time-based One-Time Password (TOTP) in Dotkernel](https://www.dotkernel.com/headless-platform/implementing-time-based-one-time-password-totp-in-dotkernel/)
<!--- blog_end --->

### Contributing and Support

- If you need support with the project, read [the support documentation](https://github.com/dotkernel/.github/blob/main/SUPPORT.md).
- For open discussions, please use [github discussion](https://github.com/orgs/dotkernel/discussions)
- For reporting security issues, please review our [security policy](https://github.com/dotkernel/.github/blob/main/SECURITY.md).
- If you wish to contribute to the project, read the [contributing guidelines](https://github.com/dotkernel/.github/blob/main/CONTRIBUTING.md)
- Learn about [git attributes](https://github.com/dotkernel/.github/blob/main/GIT_ATTRIBUTES.md)

