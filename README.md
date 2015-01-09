![Maintenance Banner]
(https://github.com/stevebauman/maintenance/blob/master/maintenance-banner.jpg)

A Preventative Maintenance Application (CMMS) for Laravel

##TO DO
* Localize all text into lang arrays
* Robust notifications - IN PROGRESS
* Robust reporting
* Customizable user dashboard
* User profile view - IN PROGRESS
* Better breadcrumb management
* Finish administration panel for managing permissions/users/groups
* Implement Print view for QR codes as well as all other data
* Lots of optimization and tweaks in views, services, controllers etc - IN PROGRESS
* Optimize views for tablet/mobile - IN PROGRESS
* Upgrade to Laravel 5.0
* Tests

##Done
* Assigned work orders view - Jan 9th 2014
* Ability to assign users to events - Jan 8th 2014
* Finish asset events with event reporting / other additions - Jan 8th 2014
* Namespace and directory tweaks / modifications - Jan 8th 2014
* Multiple calendar functionality - Jan 8th 2014
* Installation Commands - Jan 7th 2014
* Implement DB transactions for every service method - Nov 5th 2014
* Add 'Put Back Some' option for work order parts/supplies Nov 4th 2014
* User registration with public work order creation - Oct 28th 2014
* Add meter readings to assets - Oct 24th 2014
* Implement Status and Priority DB tables and functionality - Oct 23rd 2014
* Add date for end of life for assets - Oct 22nd 2014
* Implement selectable inventory metrics (LB, Litres, Tonnes etc) - Oct 22nd 2014
* Implement [Revisionable](https://github.com/VentureCraft/revisionable) for viewing edit history on records - Oct 22nd 2014
* Add soft deletes for some tables for recoverable data - Oct 21st 2014 (Work Orders, Assets & Inventory)
* Clean up routes - Oct 21st 2014
* Asset manual attachments - Oct 15th 2014
* Better category management - Oct 15th 2014

###Features
* Infinite Category Management with Laravel [Baum](https://github.com/etrepat/baum) & [JsTree](https://github.com/vakata/jstree)
* Dynamic Ajax Uploads for Attachments & Images with [Plupload](https://github.com/jildertmiedema/laravel-plupload)
* LDAP Authentication with [Corp](https://github.com/stevebauman/Corp) Combined with [Sentry](https://github.com/cartalyst/sentry)
* Work Order / Inventory / Asset Management (with Maintenance Scheduling using [FullCalendar](https://github.com/arshaw/fullcalendar))
* Administration Panel for managing users, permissions, groups, and data restoration (archive)
* [Revisionable](https://github.com/VentureCraft/revisionable) is built in for easy history viewing on changes made
* User input purification by [Purifier](https://github.com/mewebstudio/Purifier)
* And more...