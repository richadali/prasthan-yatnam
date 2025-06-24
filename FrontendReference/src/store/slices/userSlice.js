import { createSlice } from "@reduxjs/toolkit";

const counterSlice = createSlice({
  name: "counter",
  initialState: {
    name: "",
    rollNo: 0,
  },
  reducers: {
    setName: (state, action) => {
      state.name = action.payload;
    },
    increment: (state) => {
      state.rollNo = state.rollNo + 1;
    },
  },
});

export const { increment, setName } = counterSlice.actions;
export default counterSlice.reducer;
