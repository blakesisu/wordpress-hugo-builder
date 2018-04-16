# wordpress-hugo-builder

## Currently
Plugin first was designed to enable an API interface to a given hugo project with an API itself. This enabled build commands and other data to be passed to the hugo project when a wordpress event triggered (really just 'publish', but there are more events that can used).

## Goals
1. Biggest goal is to abstract plugin, with aim to let user enter API urls with accompanying endpoints, and allow user to determine what data they want to pass to APIs given.
1. Allow for user to append more logic (user middleware).
1. Allow for more events to be used to trigger API communication.
1. Determine what data should be made available for users to pass along (whole post object, and/or discrete parts).
1. Determine plugin install method.
