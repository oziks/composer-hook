## Composer Hook ##

#### Exemple : ####

``` json
# composer.json
"scripts": {
  "post-install-cmd": [
    ...
    "My\\ProjectBundle\\Composer\\ScriptHandler::removeVendorGitDirectory"
  ],
  "post-update-cmd": [
    ...
    "My\\ProjectBundle\\Composer\\ScriptHandler::removeVendorGitDirectory"
  ]
},
```