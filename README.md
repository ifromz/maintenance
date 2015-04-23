![Maintenance Banner]
(https://github.com/stevebauman/maintenance/blob/master/maintenance-banner.jpg)

[![Code Climate](https://codeclimate.com/github/stevebauman/maintenance/badges/gpa.svg)](https://codeclimate.com/github/stevebauman/maintenance)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/stevebauman/maintenance/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/stevebauman/maintenance/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/stevebauman/maintenance/v/stable.svg)](https://packagist.org/packages/stevebauman/maintenance)
[![Latest Unstable Version](https://poser.pugx.org/stevebauman/maintenance/v/unstable.svg)](https://packagist.org/packages/stevebauman/maintenance) 
[![License](https://poser.pugx.org/stevebauman/maintenance/license.svg)](https://packagist.org/packages/stevebauman/maintenance)

> **Note:** This repository contains the core code of the Maintenance application. If you want the actual pre-built application, visit the main [Maintenance App repository](https://github.com/stevebauman/maintenance-app).

## Status

This application is not yet finished and is in heavy development. When a release is tagged on Github, you will know when
it is complete.

##Important Todo's
* Started: Feb 22nd 2015    - Complete administration panel
* Started: Not yet started  - Complete client interface and functionality
* Started: Not yet started  - Complete notification functionality

##TO DO
* Move work order management to separate package - IN PROGRESS
* Robust notifications - IN PROGRESS
* Robust reporting
* Customizable user dashboard
* Implement Print view for QR codes as well as all other data
* Upgrade to Laravel 5.0
* Tests
* Revamp the way uploads are handled

##Done
* Feb 26th 2015 - Better breadcrumb management ([Laravel Breadcrumbs](https://github.com/davejamesmiller/laravel-breadcrumbs))
* Feb 26th 2015 - Restrict multiple submits through ajax requests & more optimizations
* Feb 24th 2015 - Optimize views
* Jan 14th 2015 - Moved inventory management to separate package
* Jan 9th 2015 - Assigned work orders view
* Jan 8th 2015 - Ability to assign users to events
* Jan 8th 2015 - Finish asset events with event reporting / other additions
* Jan 8th 2015 - Namespace and directory tweaks / modifications
* Jan 8th 2015 - Multiple calendar functionality
* Jan 7th 2015 - Installation Commands
* Nov 5th 2014 - Implement DB transactions for every service method
* Nov 4th 2014 - Add 'Put Back Some' option for work order parts/supplies
* Oct 28th 2014 - User registration with public work order creation
* Oct 24th 2014 - Add meter readings to assets
* Oct 23rd 2014 - Implement Status and Priority DB tables and functionality
* Oct 22nd 2014 - Add date for end of life for assets
* Oct 22nd 2014 - Implement selectable inventory metrics (LB, Litres, Tonnes etc)
* Oct 22nd 2014 - Implement [Revisionable](https://github.com/VentureCraft/revisionable) for viewing edit history on records
* Oct 21st 2014 - Add soft deletes for some tables for recoverable data (Work Orders, Assets & Inventory)
* Oct 21st 2014 - Clean up routes
* Oct 15th 2014 - Asset manual attachments
* Oct 15th 2014 - Better category management

###Features
* Multiple full calendar support with Google Calendar API (using Google Calendar means easy synchronization with your phone)
* Create events for inventory, work orders, assets and generic events
* Infinite Category Management with Laravel [Baum](https://github.com/etrepat/baum) & [JsTree](https://github.com/vakata/jstree)
* Dynamic Ajax Uploads for Attachments & Images with [Plupload](https://github.com/jildertmiedema/laravel-plupload)
* LDAP Authentication with [Corp](https://github.com/stevebauman/Corp) Combined with [Sentry](https://github.com/cartalyst/sentry)
* Work Order / Inventory / Asset Management (with Maintenance Scheduling using [FullCalendar](https://github.com/arshaw/fullcalendar))
* Administration Panel for managing users, permissions, groups, and data restoration (archive)
* [Revisionable](https://github.com/VentureCraft/revisionable) is built in for easy history viewing on changes made
* User input purification by [Purifier](https://github.com/mewebstudio/Purifier)
* And more...