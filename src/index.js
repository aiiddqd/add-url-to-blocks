import { __ } from "@wordpress/i18n";
import { addFilter } from "@wordpress/hooks";
import { InspectorControls } from "@wordpress/block-editor";
import {
  ExternalLink,
  PanelBody,
  PanelRow,
  TextControl,
} from "@wordpress/components";

function addControls(BlockEdit) {
  return (props) => {
    const { name, attributes, setAttributes } = props;

    // Early return if the block is not the Image block.
    if (name !== "core/cover") {
      return <BlockEdit {...props} />;
    }

    

    return (
      <>
        <BlockEdit {...props} />
        <InspectorControls>
          <PanelBody title={__("URL", "add-url-to-blocks")}>
            <PanelRow>
              <TextControl
                label="href"
                onChange={(value) => {
                  setAttributes({
                    urlCustom: value,
                  });
                }}
                value={attributes.urlCustom}
              />
            </PanelRow>
          </PanelBody>
        </InspectorControls>
      </>
    );
  };
}

function addAttribute(settings, name) {
  // Only add the attribute to Image blocks.
  if (name === "core/cover") {
    settings.attributes = {
      ...settings.attributes,
      urlCustom: {
        type: "string",
      },
    };
  }

  return settings;
}

addFilter("editor.BlockEdit", "ddev/add-url-to-blocks-controls", addControls);

addFilter("blocks.registerBlockType", "ddev/add-url-to-blocks", addAttribute);
