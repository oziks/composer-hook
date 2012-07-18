## Composer Hook ##

#### Exemple : ####

Deletes the .git directory of symfony vendors.
In case if you push a vendors on project repository :

``` json
"scripts": {
  "post-install-cmd": [
    "My\\ProjectBundle\\Composer\\ScriptHandler::removeVendorGitDirectory"
  ],
  "post-update-cmd": [
    "My\\ProjectBundle\\Composer\\ScriptHandler::removeVendorGitDirectory"
  ]
},
```