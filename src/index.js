import { __ } from "@wordpress/i18n";
import { addFilter } from "@wordpress/hooks";
import { InspectorControls } from "@wordpress/block-editor";
import {
  ExternalLink,
  PanelBody,
  PanelRow,
  TextControl,
  ToggleControl,
} from "@wordpress/components";

function addControls(BlockEdit) {
  return (props) => {
    const { name, attributes, setAttributes } = props;

    // Early return if the block is not the Image block.
    if (name !== "core/cover") {
      return <BlockEdit {...props} />;
    }

    // Retrieve selected attributes from the block.
    // const { urlCustom } = attributes;
    const { urlCustom, urlCustomNewTab } = attributes;

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
                value={urlCustom}
              />
            </PanelRow>
            <PanelRow>
              <ToggleControl
                label="new tab"
                checked={urlCustomNewTab}
                onChange={(value) => {
                  setAttributes({
                    urlCustomNewTab: value,
                  });
                }}
                value={urlCustomNewTab}
              />
            </PanelRow>
          </PanelBody>
        </InspectorControls>
      </>
    );
  };
}

function addAttribute(settings, name) {
  if (name !== "core/cover") {
    return settings;
  }
  settings.attributes = {
    ...settings.attributes,
    urlCustom: {
      type: "string",
    },
    urlCustomNewTab: {
      type: "boolean",
      default: false,
    },
  };
  return settings;
}

addFilter("editor.BlockEdit", "ddev/add-url-to-blocks-controls", addControls);

addFilter("blocks.registerBlockType", "ddev/add-url-to-blocks", addAttribute);
