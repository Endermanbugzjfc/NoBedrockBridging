<!-- btw this is directly based on multiworld's readme thats why they look alike lol -->
# 🛑 No Bedrock Bridging
🗨 NPC dialogue
🎞 Animation guide
🚧 Movement constraint
🔐 Permission node for customisation
🌐 Multi-language system

<p align="center">
  <img height=480 alt="Demonstration GIF" src="https://github.com/Endermanbugzjfc/NoBedrockBridging/assets/53002741/dc8f690f-a7d5-4316-8aa7-a6dbd1533e9e"><br>
  <a href="https://poggit.pmmp.io/p/NoBedrockBridging">  
    <img alt="Poggit release (latest)" src="https://poggit.pmmp.io/shield.downloads/NoBedrockBridging?style=for-the-badge">  
  </a>
  <a href="https://github.com/Endermanbugzjfc/NoBedrockBridging">  
    <img alt="GitHub release (latest by SemVer including pre-releases)" src="https://img.shields.io/github/downloads-pre/Endermanbugzjfc/NoBedrockBridging/:tag/total?style=for-the-badge">
  </a>
</p>

This plugin pops an NPC dialogue to warn players that they cannot be Bedrock bridging, with a guiding animation.

At the same time, it also limits the player's movement so the player will be less likely to fall from the height. This movement constraint will turns off upon the dialogue gets closed or upon the player gets hurt.

# 📥 Installation
After you have settled the PHARs for [Customies](https://poggit.pmmp.io/p/customies/) and [this plugin,](https://poggit.pmmp.io/p/RankSystem/) you will still need to setup the resource pack or otherwise, the animation won't be visible to the player!

1. If your server is freshly installed, start it for once and quickly turn off. This allows it to generate the essential files.
2. Locate the `resources_packs` folder and its `resource_packs.yml` file in your server.
3. Download the resource pack `NoBedrockBridging_RP.zip` file from [here.](https://github.com/Endermanbugzjfc/NoBedrockBridging/releases/latest)
4. Do NOT unzip the file, directly it in `resources_packs`.
5. Open `resource_packs.yml` with a text editor.
6. Registry the file name, which should be `NoBedrockBridging_RP.zip` if you have not yet changed it.
7. It is recommended to also turn on `force_resources`. That will result in players being kicked if they accidentally or intentionally pressed the "join without pack" button.

If your text editor has code highlighting, you may notice that some texts are grayed out. Those are comments. It is recommended to keep that around for future reference. However, if you think that bother your way, you may chooose to remove them.

At the end, your setup should look similar to this:
```yml
#This configuration file controls global resources used on your PocketMine-MP server.

#Choose whether players must use your chosen resource packs to join the server.
#NOTE: This will do nothing if there are no resource packs in the stack below.
force_resources: true
resource_stack:
- NoBedrockBridging_RP.zip
  #Resource packs here are applied from bottom to top. This means that resources in higher packs will override those in lower packs.
  #Entries here must indicate the filename of the resource pack.
  #Example
  # - natural.zip
  # - vanilla.zip
  #If you want to force clients to use vanilla resources, you must place a vanilla resource pack in your resources folder and add it to the stack here.
  #To specify a resource encryption key, put the key in the <resource>.key file alongside the resource pack. Example: vanilla.zip.key
```
# 🔐 Permission node
- `nobedrockbridging.bypass`: One is allowed to Bedrock bridging when attached this perm. This permission is not attached nobody by default.

*Want to allow Bedrock bridging for certain groups of people? Use (RankSystem)[https://poggit.pmmp.io/p/RankSystem/] achieve it!*

# 🌐 Existing languages

- English
- Chinese Traditional & Simplified

# 📜 License
The code of both the plugin and resource pack is open-sourced under the [Apache-2 license.](https://github.com/Endermanbugzjfc/NoBedrockBridging/blob/master/LICENSE.md)
