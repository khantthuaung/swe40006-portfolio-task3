# SWE40006 — Deployment Activity 3

Azure deployment portfolio for **SWE40006 Software Deployment and Evolution**, covering the HD pathway: Tasks **3.1, 3.2 and 3.3**. Applications were developed or deployed using Visual Studio Code on macOS and hosted on Azure App Service.

## Applications and verification links

| Task | Application | Public URL | Source |
|---|---|---|---|
| 3.1 | Existing Microsoft ASP.NET Core sample | [Open sample](https://swe40006-task3-khantthuaung-gzeug0dab3h7d6dk.malaysiawest-01.azurewebsites.net/) | [Original Microsoft repository](https://github.com/Azure-Samples/dotnetcore-docs-hello-world) |
| 3.2 | C# Study Hours Calculator | [Open calculator](https://swe40006-studyhour-khantthuaung-anava6azcbded0g2.malaysiawest-01.azurewebsites.net/) | [StudyHoursCalculator](StudyHoursCalculator/) |
| 3.3 | PHP Temperature Converter | [Open converter](https://swe40006-temperature-khantthuaung-a3h0hacsgeepd2bh.malaysiawest-01.azurewebsites.net/) | [php-app](php-app/) |

**Availability:** the C# calculator was deliberately stopped on 2 October 2026 to demonstrate Task 3.2 deactivation. Its URL may therefore show an unavailable response. The sample and PHP converter were last verified running on that date. These are recorded assessment results, not a live uptime guarantee.

## Repository structure

```text
StudyHoursCalculator/   ASP.NET Core Razor Pages application
php-app/                PHP temperature converter
README.md               Setup, deployment and verification notes
```

The existing Microsoft sample is **not included in this repository**. Task 3.1 references its original source directly; it is not claimed as original student work. Refer to the upstream repository for its license and attribution.

## Task 3.1 — deploy an existing application

The existing [.NET Hello World sample from Microsoft Azure Samples](https://github.com/Azure-Samples/dotnetcore-docs-hello-world) was run locally, published and deployed to Azure using VS Code's Azure App Service extension. The version used targeted .NET 10 and provided Home, Counter and Weather pages.

For a separate local checkout:

```bash
git clone https://github.com/Azure-Samples/dotnetcore-docs-hello-world.git
cd dotnetcore-docs-hello-world
DOTNET_ENVIRONMENT=Development ASPNETCORE_ENVIRONMENT=Development dotnet run --no-launch-profile
```

The upstream repository may change over time; check its project file and README for the required SDK when reproducing the deployment.

## Task 3.2 — C# Study Hours Calculator

An ASP.NET Core Razor Pages application that calculates total study hours from daily hours and the number of days.

- Server-side calculation: daily hours multiplied by days.
- Required-field and range validation: 0–24 hours per day and 1–365 days.
- Result display and Reset action.
- Published to Azure and subsequently stopped to demonstrate deactivation.

### Run locally

Prerequisite: .NET 10 SDK.

```bash
cd StudyHoursCalculator
dotnet restore
dotnet build
DOTNET_ENVIRONMENT=Development ASPNETCORE_ENVIRONMENT=Development dotnet run --no-launch-profile
```

Open the localhost URL printed in the terminal. Press Control+C to stop the server.

### Publish

From the `StudyHoursCalculator` directory:

```bash
dotnet publish -c Release -o ./bin/Publish
```

In VS Code, right-click `bin/Publish`, select **Deploy to Web App**, and select the calculator's Azure Web App. Deployment uses the published output rather than the source directory.

## Task 3.3 — PHP Temperature Converter

A PHP web application that converts temperatures in both directions:

- Celsius to Fahrenheit: `(C × 9 / 5) + 32`.
- Fahrenheit to Celsius: `(F − 32) × 5 / 9`.
- Numeric-input and conversion-direction validation.
- Escaped output, results displayed to two decimal places, and a Reset action.

### Run locally

The development environment used PHP 8.5.11 installed with Homebrew.

```bash
cd php-app
php -l index.php
php -S localhost:8000
```

Open [localhost:8000](http://localhost:8000). The PHP built-in server is used for local development; Azure App Service hosts the deployed application.

### Deploy

In VS Code, right-click the `php-app` folder containing `index.php`, select **Deploy to Web App**, and select the PHP Azure Web App. PHP does not require the .NET publish command.

## Azure configuration

| Setting | Value used |
|---|---|
| Subscription | Azure for Students |
| Resource group | `rg-swe40006-task3` |
| Region | Malaysia West |
| Operating system | Linux |
| App Service plan | `ASP-rgswe40006task3-92cc` |
| Pricing tier | Free F1 |
| C# and sample runtime | .NET 10 (LTS) |
| PHP runtime | PHP 8.5 |
| Deployment tool | Azure App Service extension for VS Code |

The apps use separate Web App resources on the shared plan. The calculator was stopped at the individual app level; the shared plan and other applications were retained.

## Recorded verification

These results were captured during the assignment on 2 October 2026:

| Application | Check | Observed result |
|---|---|---|
| Microsoft sample | Public Counter interaction | Counter displayed 7 |
| C# calculator, local | 4 hours/day × 5 days | 20 total hours |
| C# calculator, local | −1 daily hours | Validation message displayed |
| C# calculator | Release publish and VS Code deployment | Succeeded |
| C# calculator, Azure | 2 hours/day × 4 days | 8 total hours |
| C# calculator, Azure | Deactivation | Azure status showed Stopped |
| PHP | `php -l index.php` | No syntax errors detected |
| PHP converter, local | 23°F to Celsius | −5.00°C |
| PHP converter, Azure | 212°C to Fahrenheit | 413.60°F |
| PHP converter | VS Code deployment | Succeeded |

The submitted report contains selected screenshots and captions. This table does not claim that every possible input or error case was tested.

## Troubleshooting notes

- Local Blazor sample assets initially failed when running build output in Production. Explicitly setting the local environment to Development resolved the issue.
- English .NET CLI output was selected with `export DOTNET_CLI_UI_LANGUAGE=en-US`.
- An initial university subscription lacked permission to create resource groups; the assignment deployments used the Azure for Students subscription with Owner access.

## Submission

The assignment submission is a separate PDF or Word report covering Task 3 only, with student/unit details, attempted level, explanations, labelled evidence and public verification links. This repository provides source access; generated build outputs, credentials and publish profiles should not be committed.
