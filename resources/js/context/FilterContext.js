import React from "react";

// set the defaults
const FilterContext = React.createContext({
  language: "en",
  setLanguage: () => {}
});

export default FilterContext;
