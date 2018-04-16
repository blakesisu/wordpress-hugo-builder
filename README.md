# wordpress-hugo-builder

## Current
Plugin first was designed to enable an API interface to a given hugo project with an API itself. This enabled build commands and other data to be passed to the hugo project when a wordpress event triggered (really just 'publish', but there are more events that can used).

## Get Started
1. Clone into wordpress plugin directory
1. Elaborate more steps for this (once decoupled from hugo workflow)

## To Do
- [ ] Biggest goal is to abstract plugin, with aim to let user enter API urls with accompanying endpoints, and allow user to determine what data they want to pass to APIs given.
- [ ] Allow for user to append more logic (user middleware).
- [ ] Allow for more events to be used to trigger API communication.
- [ ] Determine what data should be made available for users to pass along (whole post object, and/or discrete parts).
- [ ] Determine plugin install method.

## Project Structure
- **js** - javascript files for plugin behavior in admin interface
- **classes** - php class files for plugin functionality
	- **sensors** - php class files for wordpress event hooks
